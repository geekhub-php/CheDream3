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
        $kernel = static::createKernel();
        $kernel->boot();
        $user = $kernel->getContainer()->get('doctrine.odm.mongodb.document_manager')->getRepository('AppBundle:User')->findOneBy([]);

        $client   = static::createClient();
        $client->request('GET', '/users/' . $user->getId());
        $response = $client->getResponse();

        $this->assertEquals($response->getStatusCode(), 200);
    }
}
