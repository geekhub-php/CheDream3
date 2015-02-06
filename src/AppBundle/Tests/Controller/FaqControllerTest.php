<?php

namespace AppBundle\Tests\Controller;

class FaqControllerTest extends AbstractApiTest
{
    public function testGet()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/faqs');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }
}
