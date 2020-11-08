<?php

namespace App\Tests\Integration;

class IntegrationTest extends AbstractIntegrationTest
{
    public function testHomePageShouldNotExist()
    {
        $response = self::getClient()->get('/', []);

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testTestPersonShouldBe()
    {
        $response = self::getClient()->get('/api/person/1', ['http_errors' => false]);
        $this->assertEquals(200, $response->getStatusCode());

        $result = json_decode($response->getBody());
        $this->assertEquals(1, $result->id);
        $this->assertEquals("Veit", $result->name);
        $this->assertEquals("Bach", $result->surname);
        $this->assertEquals(1, $result->husbandInFamilies[0]->id);
    }

    public function testTestFamilyShouldBe()
    {
        $response = self::getClient()->get('/api/family/1', ['http_errors' => false]);
        $this->assertEquals(200, $response->getStatusCode());

        $result = json_decode($response->getBody());
        $this->assertEquals(1, $result->id);
        $this->assertEquals(1, $result->husband->id);
        $this->assertEquals("Veit", $result->husband->name);
        $this->assertEquals("Bach", $result->husband->surname);
        $this->assertEquals(2, $result->children[0]->id);
        $this->assertEquals("Johannes Hans", $result->children[0]->name);
        $this->assertEquals("Bach", $result->children[0]->surname);
    }
}
