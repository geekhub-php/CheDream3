<?php

namespace AppBundle\Tests\Controller;

class FinancialResourceControllerTest extends AbstractApiTest
{
    public function testGetFinancialResourcesAction()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/financial/resources');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }
}
