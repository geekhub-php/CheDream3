<?php

namespace AppBundle\Tests\Controller;

class StatusControllerTest extends AbstractApiTest
{
    public function testGetStatusAction()
    {
        $client   = static::createClient();
        $client->request('GET', '/status');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }
}
