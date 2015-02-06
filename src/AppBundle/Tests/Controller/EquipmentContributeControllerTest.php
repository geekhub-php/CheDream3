<?php

namespace AppBundle\Tests\Controller;

class EquipmentContributeControllerTest extends AbstractApiTest
{
    public function testGet()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/equipment/contributes');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }
}
