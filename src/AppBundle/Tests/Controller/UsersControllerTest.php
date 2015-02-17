<?php

namespace AppBundle\Tests\Controller;

use Guzzle\Http\Client;

class UsersControllerTest extends AbstractApiTest
{
    public function testGetUsersAction()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/users');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }

    public function testGetUserAction()
    {
        $client = new Client("http://chedream.local/app_dev.php");
        $request = $client->get('/users/54d1de7530d0c3bf178b4567');
        $response = $request->send();

        $this->assertEquals($response->getStatusCode(),200);
    }
}
