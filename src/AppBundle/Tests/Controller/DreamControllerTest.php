<?php

namespace Acme\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DreamControllerTest extends WebTestCase
{
    public function testGet()
    {$client   = static::createClient();
            $crawler  = $client->request('GET', '/api/dreams/');

        $response = $client->getResponse();

        $this->assertEquals($response, 200);
    }

}
