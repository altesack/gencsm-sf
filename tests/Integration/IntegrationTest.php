<?php

namespace App\Tests\Integration;

class IntegrationTest extends AbstractIntegrationTest
{

    public function testHomePageShouldNotExist()
    {
        $response = self::getClient()->get('/', []);

        $this->assertEquals(404, $response->getStatusCode());
    }

// TODO move old behat "get a person" test here
//Feature: Person feature
//    Scenario: Get a person
//        When I send a "GET" request to "/api/person/1"
//        Then the response status code should be 200
//        And the response should be in JSON
//        And the header "Content-Type" should be equal to "application/json"
//        And the JSON nodes should contain:
//            | id                       | 1        |
//            | name                     | Veit     |
//            | surname                  | Bach     |
//            | husbandInFamilies[0].id  | 1        |

    public function testTestPersonShouldBe()
    {
        $response = self::getClient()->get('/api/person/1', ['http_errors' => false]);

        $this->assertEquals(200, $response->getStatusCode());
    }

// TODO move old behat "get a family" test here
//Feature: Family feature
//    Scenario: Get a person
//        When I send a "GET" request to "/api/family/1"
//        Then the response status code should be 200
//        And the response should be in JSON
//        And the header "Content-Type" should be equal to "application/json"
//        And the JSON nodes should contain:
//            | id                       | 1        |
//            | husband.id               | 1        |
//            | husband.name             | Veit     |
//            | husband.surname          | Bach     |
//            | children[0].id           | 2        |
//            | children[0].name         | Johannes Hans  |
//            | children[0].surname      | Bach     |
//            | children[0].id           | 2        |
//            | children[0].id           | 2        |
//            | children[0].id           | 2        |

    public function testTestFamilyShouldBe()
    {
        $response = self::getClient()->get('/api/person/1', ['http_errors' => false]);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
