<?php

namespace AppBundle\Tests\Controller;

class DreamControllerTest extends AbstractApiTest
{
    public function testGet()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/dreams');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }
}
