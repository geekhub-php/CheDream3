<?php

namespace AppBundle\Tests\Controller;

class DreamControllerTest extends AbstractController
{
    /**
     * @dataProvider providerData
     */
    public function testGetDreamsAction($path, $sortOrder1, $pageCount1, $countDreams1, $sortOrder2, $pageCount2, $countDreams2)
    {
        $client = static::createClient();

        $client->request('GET', $path);

        $response = $client->getResponse();

        $this->assertTrue($client->getResponse()->isSuccessful());

        $container = $this->getContainer();

        $serializer = $container->get('jms_serializer');

        $dreamsResponse = $serializer->deserialize($response->getContent(), 'AppBundle\Model\DreamsResponse', 'json');

        $this->assertEquals($dreamsResponse->getPageCount(), $pageCount1);
        $this->assertEquals($dreamsResponse->getSortOrder(), $sortOrder1);
        $this->assertCount($countDreams1, $dreamsResponse->getDreams());

        $this->assertNotEquals($dreamsResponse->getPageCount(), $pageCount2);
        $this->assertNotEquals($dreamsResponse->getSortOrder(), $sortOrder2);
        $this->assertNotCount($countDreams2, $dreamsResponse->getDreams());
    }

    public function testGetDreamAction()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/dreams/sunt');

        $response = $client->getResponse();
    }

    public function providerData()
    {
        return [
            ['/dreams', 'DESC', 4, 10, 'ABS', 8, 9],
            ['/dreams?limit=4&page=3&sort_by=createdAt&sort_order=ASC', 'ASC', 9, 4, 'DESC', 5, 6],
            ['/dreams?limit=6&page=1&sort_by=updatedAt&sort_order=DESC', 'DESC', 6, 6, 'ASC', 8, 2],
            ['/dreams?limit=3&page=2&sort_by=createdAt&sort_order=ASC', 'ASC', 12, 3, 'DESC', 4, 1],
            ['/dreams?limit=3&page=2&sort_by=updatedAt&sort_order=DESC', 'DESC', 12, 3, 'ASC', 9, 6],
            ['/dreams?limit=7&page=3&sort_by=createdAt&sort_order=ASC', 'ASC', 6, 7, 'DESC', 11, 8],
        ];
    }
}
