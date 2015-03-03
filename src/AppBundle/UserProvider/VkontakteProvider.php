<?php

namespace Geekhub\UserBundle\UserProvider;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Guzzle\Http\Client;
use Geekhub\UserBundle\Entity\User;

class VkontakteProvider extends AbstractSocialNetworkProvider
{
    public function setUserData(User $user, UserResponseInterface $response)
    {
        $responseArray = $response->getResponse();

        $user->setFirstName($responseArray['response'][0]['first_name']);
        $user->setMiddleName($responseArray['response'][0]['nickname']);
        $user->setLastName($responseArray['response'][0]['last_name']);
        $user->setEmail('id'.$user->GetVkontakteId().'@example.com'); //is not real, but unique email is required for FosUserBundle

        if ($remoteImg = $this->vkontakteGetProfileField($user->GetVkontakteId(), $response->getAccessToken(), 'photo_big')) {
            $profilePicture = $this->getMediaFromRemoteImg($remoteImg, md5('fb'.$user->GetVkontakteId()).'.jpg');
            $user->setAvatar($profilePicture);
        } else {
            //write log's message
            $profilePicture = $this->getDefaultAvatar();
            $user->setAvatar($profilePicture);
            $logger = $this->container->get('logger');
            $logger->addError(sprintf('Error getting avatar from vkontakte: VkontakteProvider::vkontakteGetProfileField(). vkontakteId: %d', $user->getVkontakteId()));
        }

        if ($birthday = $this->vkontakteGetProfileField($user->GetVkontakteId(), $response->getAccessToken(), 'bdate')) {
            if (substr_count($birthday, '.') == 2) {
                $dateBirthday = \DateTime::createFromFormat('j.n.Y', $birthday);
            } elseif (substr_count($birthday, '.') == 1) {
                $dateBirthday = \DateTime::createFromFormat('j.n', $birthday);
            }

            if (isset($dateBirthday)) {
                $user->setBirthday($dateBirthday);
            }
        }

        return $user;
    }

    private function vkontakteGetProfileField($uid, $token, $field)
    {
        $client = new Client();
        $request = $client->get('https://api.vk.com/method/getProfiles?uid='.$uid.'&fields='.$field.'&access_token='.$token);
        try {
            $response = $request->send();
        } catch (RequestException $e) {
            $logger = $this->container->get('logger');
            $logger->addError(sprintf('Error requesting data from vkontakte. User id: %d, field: %s', $uid, $field));

           return null;
        }
        $responseBody = $response->getBody()->__toString();

        $result = $this->serializer->deserialize($responseBody, 'Geekhub\UserBundle\Model\VkontakteResponse', 'json');

        if ($result) {
            return $result->getResponse($field);
        }
        $logger = $this->container->get('logger');
        $logger->addError(sprintf('Error deserializing data from vkontakte. User id: %d, field: %s.', $uid, $field));

        return null;
    }
}
