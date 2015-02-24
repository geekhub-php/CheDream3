<?php

namespace AppBundle\Tests\Controller;

class DreamControllerTest extends AbstractApiTest
{
    /**
     * @dataProvider providerData
     */
    public function testGetDreamsAction($sortOrder, $pageCount)
    {
        $client = static::createClient();

        $client->request('GET', '/dreams');

        $response = $client->getResponse();

        $kernel = static::createKernel();
        $kernel->boot();

        $container = $kernel->getContainer();

        $serializer =$container->get('jms_serializer');

        $dreamsResponse = $serializer->deserialize($response->getContent(), 'AppBundle\Model\DreamsResponse', 'json');

        $this->assertEquals($dreamsResponse->getPageCount(),$pageCount);
        $this->assertEquals($dreamsResponse->getSortOrder(),$sortOrder);
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
            ['DESC', 3]
        ];
    }
}
