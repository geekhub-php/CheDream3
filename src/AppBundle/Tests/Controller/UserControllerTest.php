<?php

namespace AppBundle\Tests\Controller;

class UserControllerTest extends AbstractApiTest
{
    public function testGet()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/users');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }
}
