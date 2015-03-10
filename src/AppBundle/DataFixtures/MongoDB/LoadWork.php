<?php

namespace AppBundle\DataFixtures\MongoDB;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;

class LoadWork extends DataFixtureLoader
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
}
