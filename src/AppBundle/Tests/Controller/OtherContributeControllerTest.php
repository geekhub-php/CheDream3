<?php

namespace AppBundle\Tests\Controller;

class OtherContributeControllerTest extends AbstractApiTest
{
    public function testGet()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/other/contributes');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }
}
