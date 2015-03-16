<?php

namespace AppBundle\DataFixtures\MongoDB;

use Application\Sonata\MediaBundle\Document\Media;
use Application\Sonata\MediaBundle\DataFixtures\MongoDB\AbstractMediaLoader;
use Symfony\Component\Finder\Finder;

class LoadWork extends AbstractMediaLoader
{
    /**
     * {@inheritDoc}
     */
    protected function getFixtures()
    {
        $this->addPictures();

        return  array(
            __DIR__.'/dynamic.yml',
            __DIR__.'/static.yml',
        );
    }

    /**
     * This method return all MediaObjects.
     *
     * @return \Application\Sonata\MediaBundle\Document\Media[]|array
     */
    public function getMediaObjects()
    {
        $mediaObjects = $this->manager->getRepository("ApplicationSonataMediaBundle:Media")->findAll();

        return $mediaObjects;
    }

    /**
     * This method saves the images in Media Collection.
     */
    private function addPictures()
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__.'/images');

        foreach ($finder as $file) {
            $this->setMediaContent(
                __DIR__.'/images/'.$file->getRelativePathname(),
                'pictures',
                'sonata.media.provider.image'
            );
        }
    }
}
