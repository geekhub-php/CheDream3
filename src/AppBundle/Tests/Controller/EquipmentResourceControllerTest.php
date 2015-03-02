<?php

namespace AppBundle\Tests\Controller;

class EquipmentResourceControllerTest extends AbstractApiTest
{
    public function testGetEquipmentResourcesAction()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/equipment/sunt/resources');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }
}
