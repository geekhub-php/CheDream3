<?php

namespace AppBundle\UserProvider;

use AppBundle\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use FOS\RestBundle\View\View;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\LockedException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use AppBundle\UserProvider\FacebookProvider;
use AppBundle\UserProvider\VkontakteProvider;
use AppBundle\UserProvider\OdnoklassnikiProvider;

class DreamUserProvider extends BaseClass implements UserProviderInterface, OAuthAwareUserProviderInterface
{
    protected $session;

    /** @var FacebookProvider $facebookProvider */
    protected $facebookProvider;

    /** @var VkontakteProvider $vkontakteProvider */
    protected $vkontakteProvider;

    public function connectUser(DocumentManager $dm, SecurityContext $securityContext, $accessToken, $id, $service)
    {
        $property = strtolower($service)."Id";

        $user = $dm->getRepository('AppBundle:User')
                   ->findOneBy([$property => $id]);

        $view = new View();

        if (!$user) {
            $view->setStatusCode(302);
        } else {
            $token = new OAuthToken($accessToken);
            $token->setResourceOwnerName($property);
            $token->setUser($user);
            $token->setAuthenticated(true);

            $securityContext->setToken($token);
        }

        return $view;
    }

    public function createUser(Serializer $serializer, $data, $service, $id)
    {
        $user = $serializer->deserialize($data, 'AppBundle\Document\User', 'json');

        $accessor = new PropertyAccessor();

        $accessor->setValue($user, strtolower($service)."Id", $id);

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();

        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();

        $setter = 'set'.ucfirst($service);
        $setterId = $setter.'Id';

        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setterId(null);
            $this->updateEmails($user, $previousUser);
            $this->updateOtherSocialIds($user, $previousUser);
            $this->mergeDreams($user, $previousUser);
            $this->mergeContributions($user, $previousUser);
            $this->userManager->deleteUser($previousUser);
        }

        //we connect current user
        $user->$setterId($username);

        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $username = $response->getUsername();
//        $user = $this->loadUserByUsername($username);
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));

        if (null === $user || null === $username) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set'.ucfirst($service);
            $setterId = $setter.'Id';
            $userDataServiceName = lcfirst($service).'Provider';

            $user = $this->userManager->createUser();
            $user->$setterId($username);

            // I use different setters setters for each type of oath providers:
            // for example setVkontakteUser(...),  setFacebookUser(...)
            // the actual name of setter is in the variable $setterUser.
            $user = $this->$userDataServiceName->setUserData($user, $response);
            $user->setUsername(uniqid());
            //$user->setEmail($username);
            $user->setPassword($username);
            $user->setEnabled(true);

            if ($hasUser = $this->userManager->findUserByEmail($user->getEmail())) {
                $user->setEmail($username."@example.com");
            }

            return $user;
        }

        $user = parent::loadUserByOAuthUserResponse($response);
        if (!$user->isAccountNonLocked()) {
            $this->session->getFlashBag()->add(
                'locked',
                'user.locked'
            );
            throw new LockedException();
        }

        return $user;
    }

    /**
     * @param Session $session
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    public function setFacebookProvider(FacebookProvider $facebookProvider)
    {
        $this->facebookProvider = $facebookProvider;
    }

    public function setVkontakteProvider(VkontakteProvider $vkontakteProvider)
    {
        $this->vkontakteProvider = $vkontakteProvider;
    }

    public function setOdnoklassnikiProvider(OdnoklassnikiProvider $odnoklassnikiProvider)
    {
        $this->odnoklassnikiProvider = $odnoklassnikiProvider;
    }

    protected function updateEmails(User $user, User $previousUser)
    {
        if ($user->isFakeEmail() && !$previousUser->isFakeEmail()) {
            $realEmail = $previousUser->getEmail();

            $previousUser->setEmail(uniqid().$previousUser::FAKE_EMAIL_PART);
            $previousUser->setEmailCanonical($previousUser->getEmail());

            $this->userManager->updateUser($previousUser);

            $user->setEmail($realEmail);
            $user->setEmailCanonical($realEmail);
        }
    }

    protected function updateOtherSocialIds(User $user, User $previousUser)
    {
        $propertyAccessor = new PropertyAccessor();
        $socialIds = $previousUser->getNotNullSocialIds();

        foreach ($socialIds as $socialKey => $socialId) {
            $socialKey = $socialKey.'Id';
            $propertyAccessor->setValue($previousUser, $socialKey, null);
        }

        $this->userManager->updateUser($previousUser);

        foreach ($socialIds as $socialKey => $socialId) {
            $socialKey = $socialKey.'Id';
            $currentSocialId = $propertyAccessor->getValue($user, $socialKey);

            if ($currentSocialId) {
                throw new \Exception(sprintf('You already have registred by "%s" social network, and account "%s %s" can\t be merged'), $socialKey, $previousUser->getFirstName(), $previousUser->getLastName());
            }

            $propertyAccessor->setValue($user, $socialKey, $socialId);
        }

        $this->userManager->updateUser($user);
    }

    protected function mergeDreams(User $user, User $previousUser)
    {
        foreach ($previousUser->getFavoriteDreams() as $dream) {
            if (!$user->getFavoriteDreams()->contains($dream)) {
                $user->addFavoriteDream($dream);
                $previousUser->removeFavoriteDream($dream);
            }
        }

        foreach ($previousUser->getDreams() as $dream) {
            $dream->setAuthor($user);
            $previousUser->removeDream($dream);
            $user->addDream($dream);
        }

        $this->userManager->updateUser($previousUser);
        $this->userManager->updateUser($user);
    }

    protected function mergeContributions(User $user, User $previousUser)
    {
        foreach ($previousUser->getEquipmentContributions() as $contribution) {
            $contribution->setUser($user);
            $previousUser->removeEquipmentContribution($contribution);
            $user->addEquipmentContribution($contribution);
        }

        foreach ($previousUser->getFinancialContributions() as $contribution) {
            $contribution->setUser($user);
            $previousUser->removeFinancialContribution($contribution);
            $user->addFinancialContribution($contribution);
        }

        foreach ($previousUser->getWorkContributions() as $contribution) {
            $contribution->setUser($user);
            $previousUser->removeWorkContribution($contribution);
            $user->addWorkContribution($contribution);
        }

        foreach ($previousUser->getOtherContributions() as $contribution) {
            $contribution->setUser($user);
            $previousUser->removeOtherContribution($contribution);
            $user->addOtherContribution($contribution);
        }

        $this->userManager->updateUser($previousUser);
        $this->userManager->updateUser($user);
    }
}
