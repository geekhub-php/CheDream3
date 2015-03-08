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
                           ->findOneById('deleniti');

        $financial_resource = new FinancialResource();
        $financial_resource->setTitle('nostrum');
        $financial_resource->setQuantity(50);

        $financial_resource2 = new FinancialResource();
        $financial_resource2->setTitle('myTesttt11');
        $financial_resource2->setQuantity(5021);

        $dreamTmp = new Dream();
        $dreamTmp->setTitle('test1');
        $dreamTmp->setDescription('test2');
        $dreamTmp->addResource($financial_resource);
        $dreamTmp->addResource($financial_resource2);

        $dreamNew = $client->getContainer()->get('app.services.object_updater')->updateObject($dreamOld, $dreamTmp);

        $this->assertEquals($dreamNew->getTitle(), $dreamTmp->getTitle());
        $this->assertEquals($dreamNew->getDescription(), $dreamTmp->getDescription());
        $this->assertEquals($dreamNew->getResources()->count(), $dreamTmp->getResources()->count());
        $this->assertEquals($dreamNew->getResources()[4]->getQuantity(), $dreamTmp->getResources()[0]->getQuantity());
    }
}
