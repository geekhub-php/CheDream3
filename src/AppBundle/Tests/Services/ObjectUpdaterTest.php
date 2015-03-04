<?php

namespace AppBundle\Tests\Services;

use AppBundle\Tests\Controller\AbstractApiTest;
use AppBundle\Document\Dream;
use AppBundle\Document\FinancialResource;

class ObjectUpdaterTest extends AbstractApiTest
{
    public function testUpdateObject()
    {
        $client   = static::createClient();

        $dreamOld = $client->getContainer()
                           ->get('doctrine_mongodb.odm.document_manager')
                           ->getRepository('AppBundle:Dream')
                           ->findOneBySlug('sunt');
        
        $financial_resource = new FinancialResource();
        $financial_resource->setTitle('ex');
        $financial_resource->setQuantity(50);

        $dreamTmp = new Dream();
        $dreamTmp->setTitle('test1');
        $dreamTmp->setDescription('test2');
        $dreamTmp->addDreamFinancialResource($financial_resource);

        $dreamNew = $client->getContainer()->get('app.services.object_updater')->updateObject($dreamOld, $dreamTmp);

        $this->assertEquals($dreamNew->getTitle(), $dreamTmp->getTitle());
        $this->assertEquals($dreamNew->getDescription(), $dreamTmp->getDescription());
    }
}
