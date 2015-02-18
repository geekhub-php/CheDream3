<?php

namespace AppBundle\Tests\Controller;

class DreamControllerTest extends AbstractApiTest
{
    /**
     * @dataProvider providerData
     */
    public function testGetDreamsAction($status,$limit,$sort_by,$sort_order)
    {
        $client   = static::createClient();

        $crawler  = $client->request('GET', '/dreams?limit=4&status=submitted&sort_by=status_update&sort_order=DESC');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $this->assertEquals($client->getRequest()->query->get('status'),$status);
        $this->assertEquals($client->getRequest()->query->get('limit'),$limit);
        $this->assertEquals($client->getRequest()->query->get('sort_by'),$sort_by);
        $this->assertEquals($client->getRequest()->query->get('sort_order'),$sort_order);
    }

    public function testGetDreamAction()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/dreams/sunt');

        $response = $client->getResponse();

        $this->assertJsonResponse($response, 200);
    }

    public function providerData(){
        return [
            ['submitted',4,'status_update','DESC']
        ];
    }
}
