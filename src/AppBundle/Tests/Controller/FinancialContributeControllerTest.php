<?php

namespace AppBundle\Tests\Controller;

class FinancialContributeControllerTest extends AbstractApiTest
{
    public function testGet()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/financial/contributes');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }
}
