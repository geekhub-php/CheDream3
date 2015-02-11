<?php

namespace AppBundle\Tests\Controller;

class DreamControllerTest extends AbstractApiTest
{
    public function testGetDreamsAction()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/dreams');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }

    public function testGetDreamAction()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/dreams/sunt');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }
}
