<?php

namespace AppBundle\Tests\Controller;

class UserControllerTest extends AbstractApiTest
{
    public function testUsersGet()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/users');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }

    public function testUserGet()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/users/54d1de7530d0c3bf178b4567');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }
}
