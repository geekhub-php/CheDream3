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
        return  array(
            __DIR__.'/dynamic.yml',
            __DIR__.'/static.yml',
        );
    }

    public function mediaPictures()
    {
        $pictures = ['blaster','moon','star','starship'];
        $counter = $this->addPictures();
        for ($i = 0; $i < $counter; $i++) {
            $media[$i] = $this->manager->getRepository("ApplicationSonataMediaBundle:Media")->findOneByName($pictures[$i].'.jpg');
        }

        return $media;
    }

    /**
     * @return int
     */
    private function addPictures()
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__.'/images');
        $counter = 0;
        foreach ($finder as $file) {
            $this->setMediaContent(
                __DIR__.'/images/'.$file->getRelativePathname(),
                'pictures',
                'sonata.media.provider.image'
            );
            $counter++;
        }

        return $counter;
    }
}
