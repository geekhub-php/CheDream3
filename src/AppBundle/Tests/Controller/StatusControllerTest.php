<?php

namespace AppBundle\Tests\Controller;

class StatusControllerTest extends AbstractApiTest
{
    public function testGet()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/status');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }
}
