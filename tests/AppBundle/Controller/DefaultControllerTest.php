<?php

namespace Tests\AppBundle\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = new Client([
            'base_uri'        => 'http://localhost:8000',
            'timeout'         => 0,
            'allow_redirects' => false,
        ]);        
                
        $response = $client->get('/', null);

        $this->assertEquals(200, $response->getStatusCode());

    }
}
