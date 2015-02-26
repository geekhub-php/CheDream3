<?php

namespace AppBundle\Tests\Controller;

class DreamControllerTest extends AbstractApiTest
{
    /**
     * @dataProvider providerData
     */
    public function testGetDreamsAction($sortOrder, $pageCount, $countDreams)
    {
        $client = static::createClient();

        $client->request('GET', '/dreams?limit=4&page=3&sortBy=createdAt&sortOrder=DESC');

        $response = $client->getResponse();

        $kernel = static::createKernel();
        $kernel->boot();

        $container = $kernel->getContainer();

        $serializer =$container->get('jms_serializer');

        $dreamsResponse = $serializer->deserialize($response->getContent(), 'AppBundle\Model\DreamsResponse', 'json');

        $this->assertEquals($dreamsResponse->getPageCount(),$pageCount);
        $this->assertEquals($dreamsResponse->getSortOrder(),$sortOrder);
        $this->assertCount($countDreams, $dreamsResponse->getDreams());
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
            ['DESC', 8, 4]
        ];
    }
}
