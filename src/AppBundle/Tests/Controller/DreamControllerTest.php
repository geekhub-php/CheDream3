<?php

namespace AppBundle\Tests\Controller;

class DreamControllerTest extends AbstractApiTest
{
    /**
     * @dataProvider providerData
     */
    public function testGetDreamsAction($sortBy,$sortOrder,$limit,$page)
    {
        $client   = static::createClient();

        $crawler  = $client->request('GET', '/dreams');

        $response = $client->getResponse();

        $dream =  json_decode($response->getContent(),true);

        $this->assertJsonResponse($response, 200);

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertEquals($dream['sort_by'],$sortBy);
        $this->assertEquals($dream['sort_order'],$sortOrder);
        $this->assertEquals($dream['limit'],$limit);
        $this->assertEquals($dream['page'],$page);
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
            ['status_update','DESC',10,1]
        ];
    }
}
