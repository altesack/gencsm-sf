Feature: Family feature
  Scenario: Get a person
    When I send a "GET" request to "/api/family/1"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON nodes should contain:
      | id                       | 1        |
