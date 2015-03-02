<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractApiTest extends WebTestCase
{
    protected function assertJsonResponse($response, $statusCode = 200)
    {
        $this->assertEquals(
                $statusCode, $response->getStatusCode(),
                $response->getContent()
            );

        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }

//    protected function createDream()
//    {
//        $client   = static::createClient();
//        $crawler  = $client->request('POST', '/dreams');
//
//        $response = $client->getResponse();
//
//        return $response;
//    }
}
