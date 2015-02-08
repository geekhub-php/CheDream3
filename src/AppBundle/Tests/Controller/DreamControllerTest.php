<?php

namespace AppBundle\Tests\Controller;

class DreamControllerTest extends AbstractApiTest
{
    public function testDreamsGet()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/dreams');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }

    public function testDreamGet()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/dreams/sunt');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }
}
