<?php

namespace AppBundle\Tests\Controller;

class WorkContributeControllerTest extends AbstractApiTest
{
    public function testGetWorkContributesAction()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/work/contributes');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }
}
