<?php

namespace App\Tests\Integration;

//use App\Tests\Traits\CreateTestDataTrait;

use App\Tests\CreateTestDataTestCase;

class IntegrationTest extends CreateTestDataTestCase
{
//    use CreateTestDataTrait;

    /**
     * Homepage should return 404.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return void
     */

    public function testHomePageShouldNotExist()
    {
        self::$client->request('GET', '/');
        $response = self::$client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * Trying to get the person #1.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return void
     */
    public function testTestPersonShouldBe()
    {

        self::$client->request('GET', '/api/person/1');
        $response = self::$client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $result = json_decode($response->getContent());
        $this->assertObjectHasAttribute('id', $result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals('Veit', $result->name);
        $this->assertEquals('Bach', $result->surname);
        $this->assertEquals(1, $result->husbandInFamilies[0]->id);
    }

    /**
     * Trying to get the family #1.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return void
     */
    public function testTestFamilyShouldBe()
    {
        self::$client->request('GET', '/api/family/1');
        $response = self::$client->getResponse();
        $result = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertObjectHasAttribute('id', $result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals(1, $result->husband->id);
        $this->assertEquals('Veit', $result->husband->name);
        $this->assertEquals('Bach', $result->husband->surname);
        $this->assertEquals(1, count($result->children));
        $this->assertEquals(2, $result->children[0]->id);
        $this->assertEquals('Johannes Hans', $result->children[0]->name);
        $this->assertEquals('Bach', $result->children[0]->surname);
    }
}
