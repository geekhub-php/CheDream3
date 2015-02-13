<?php

namespace AppBundle\Tests\Controller;

class WorkResourceControllerTest extends AbstractApiTest
{
    public function testGetWorkResourcesAction()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/work/resources');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }
}
