<?php

namespace Application\Sonata\MediaBundle\DataFixtures\MongoDB;

use Application\Sonata\MediaBundle\Document\Media;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractMediaLoader extends AbstractFixture implements ContainerAwareInterface
{

    protected $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param string $src
     * @param string $context
     * @param string $provider
     * @param string $nameReference
     */
    protected function setMediaContent($src, $context, $provider, $nameReference)
    {
        $mediaManager = $this->container->get('sonata.media.manager.media');
        $media = new Media();
        $media->setBinaryContent($src);
        $media->setContext($context);
        $media->setProviderName($provider);
        $mediaManager->save($media);
        $this->addReference($nameReference, $media);
    }
}