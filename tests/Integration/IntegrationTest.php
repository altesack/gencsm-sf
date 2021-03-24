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
     * @return void
     */
    public function testHomePageShouldNotExist()
    {
        self::$client->request('GET', '/');
        $response = self::$client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * @return void
     */
    public function testPersonsAndFamilies()
    {
        // trying to find person with the name 'veit'
        self::$client->request('GET', '/api/person/search/veit');
        $response = self::$client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $result = json_decode($response->getContent());
        $this->assertEquals(1, $result->count);
        $this->assertIsArray($result->data);
        $this->assertCount(1, $result->data);
        $person = $result->data[0];
        $this->assertObjectHasAttribute('id', $person);
        $this->assertEquals('M', $person->sex);
        $this->assertEquals('Veit', $person->name);
        $this->assertEquals('Bach', $person->surname);

        // trying to get full info of the person
        self::$client->request('GET', "/api/person/{$person->id}");
        $response = self::$client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());

        $result = json_decode($response->getContent());
        $this->assertObjectHasAttribute('id', $result);
        $this->assertEquals('Veit', $result->name);
        $this->assertEquals('Bach', $result->surname);

        // Trying to get the family
        self::$client->request('GET', "/api/family/{$result->husbandInFamilies[0]->id}");
        $response = self::$client->getResponse();
        $result = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertObjectHasAttribute('id', $result);
        $this->assertEquals('Veit', $result->husband->name);
        $this->assertEquals('Bach', $result->husband->surname);
        $this->assertEquals(1, count($result->children));
        $this->assertEquals('Johannes Hans', $result->children[0]->name);
        $this->assertEquals('Bach', $result->children[0]->surname);
    }
}
