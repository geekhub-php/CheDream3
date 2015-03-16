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
    public function connectUser(DocumentManager $dm, SecurityContext $securityContext, $accessToken, $id, $service)
    {
        $property = strtolower($service)."Id";

        $user = $dm->getRepository('AppBundle:User')
                   ->findOneBy([$property => $id]);

        $view = new View();

        if (!$user) {
            $view->setStatusCode(302);
        } else {
            $service = strtolower($service)."Id";

            $this->authicateUser($securityContext, $user, $accessToken, $service);
        }

        return $view;
    }

    public function createUser(SecurityContext $securityContext, Serializer $serializer, $data, $accessToken, $service, $id)
    {
        $user = $serializer->deserialize($data, 'AppBundle\Document\User', 'json');

        $accessor = new PropertyAccessor();

        $accessor->setValue($user, strtolower($service)."Id", $id);

        $this->authicateUser($securityContext, $user, $accessToken, $service);

        return $user;
    }

    public function authicateUser(SecurityContext $securityContext, User $user, $accessToken, $service)
    {
        $service = strtolower($service)."Id";

        $token = new OAuthToken($accessToken);
        $token->setResourceOwnerName($service);
        $token->setUser($user);
        $token->setAuthenticated(true);

        $securityContext->setToken($token);
    }
}
