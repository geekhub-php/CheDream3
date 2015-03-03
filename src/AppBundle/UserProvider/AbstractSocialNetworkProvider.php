<?php

namespace Geekhub\UserBundle\UserProvider;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\RequestException;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use JMS\Serializer\Serializer;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\Container,
    Symfony\Component\Filesystem\Filesystem;
use Application\Sonata\MediaBundle\Entity\Media;
use Geekhub\UserBundle\Entity\User;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

abstract class AbstractSocialNetworkProvider
{
    /** @var  string $kernelWebDir */
    protected $kernelWebDir;

    /** @var  string $kernelWebDir */
    protected $uploadDir;

    /** @var  Serializer $serializer */
    protected $serializer;

    /** @var  Container $container */
    protected $container;

    /** @var  string $defaultAvatarPath */
    protected $defaultAvatarPath;

    public function __construct(Container $container, $kernelWebDir, $uploadDir, $defaultAvatarPath)
    {
        $this->container          = $container;
        $this->serializer         = $container->get('jms_serializer');
        $this->kernelWebDir       = $kernelWebDir;
        $this->uploadDir          = $uploadDir;
        $this->defaultAvatarPath  = $defaultAvatarPath;
    }

    public function getMediaFromRemoteImg($remoteImg, $localFileName)
    {
        $destination = $this->kernelWebDir.'/../web'.$this->uploadDir;
        $localImg = $destination.$localFileName;
        $defaultImg = $this->kernelWebDir.$this->defaultAvatarPath;//'/../web/images/default_avatar.png';

        if ($flagCopySuccess = $this->copyAvatar($remoteImg, $localImg)) {
            $media = new Media();
            $media->setBinaryContent($localImg);
            $media->setProviderName('sonata.media.provider.image');
            if ($flagCopySuccess) {
                $media->setContext('avatar');
            } else {
                $media->setContext('default_avatar');
                $logger = $this->container->get('logger');
                $logger->addError(sprintf('Error copying avatar in AbstractSocialNetworkProvider::copyAvatar(..) from url: %s. Using default image.', $remoteImg));
            }

            $mediaManager = $this->container->get('sonata.media.manager.media');
            $mediaManager->save($media);
        } else {
            $media = $this->getDefaultAvatar();
            $logger = $this->container->get('logger');
            $logger->addError(sprintf('Error copying avatar 2 in AbstractSocialNetworkProvider::copyAvatar(..) from url: %s. Using default image.', $remoteImg));
        }

        try {
            $filesystem = new Filesystem();
            $filesystem->remove($localImg);
        } catch (IOExceptionInterface $e) {
            $logger = $this->container->get('logger');
            $logger->addError(sprintf('Error removing temporary avatar file %s.', $remoteImg));

        }

        return $media;
    }

    private function copyAvatar($remoteImg, $localImg)
    {
        $defaultImg = $this->kernelWebDir.$this->defaultAvatarPath;//'/../web/images/default_avatar.png';
        $client = new Client();
        $request = $client->get($remoteImg);
        try {
            $response = $request->send();
        } catch (RequestException $e) {
            $filesystem = new Filesystem();
            $filesystem->copy($defaultImg, $localImg);
            $logger = $this->container->get('logger');
            $logger->addError(sprintf('Error reading avatar from url: %s. Using default image.', $remoteImg));

            return false;
        }
        $responseBody = $response->getBody();
        $fp = fopen($localImg, 'w');
        fwrite($fp, $responseBody);
        fclose($fp);

        return true;
    }

    public function getDefaultAvatar()
    {
        $defaultImg = $this->kernelWebDir.$this->defaultAvatarPath;//'/../web/images/default_avatar.png';
        $mediaManager = $this->container->get('sonata.media.manager.media');
        $media = $mediaManager->findOneBy(array('context'=>'default_avatar'));
        if (!$media) {
            $media = new Media();
            $media->setBinaryContent($defaultImg);
            $media->setProviderName('sonata.media.provider.image');
        }

        return $media;
    }

    abstract public function setUserData(User $user, UserResponseInterface $response);
}
