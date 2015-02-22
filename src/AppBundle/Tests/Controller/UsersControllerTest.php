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

        $client = new Client();
        $request = $client->get('/users/' . $user->getId());
        $response = $request->send();

        $this->assertEquals($response->getStatusCode(),200);
    }
}
