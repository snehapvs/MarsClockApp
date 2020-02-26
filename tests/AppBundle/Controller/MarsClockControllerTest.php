<?php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Unit Tests for Controller methods and HTTP Requests along with exceptions
 */
class MarsClockControllerTest extends WebTestCase
{

    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/marsclock?utc=Wednesday, 26-Feb-20 15:43:25 UTC');
        $this->assertEquals(200, $client->getResponse()
            ->getStatusCode());
        $expectedResponse = new \stdClass();
        $expectedResponse->MSD = 51955.82243566164;
        $expectedResponse->MTC = "19:44:18";
        $this->assertEquals(json_encode($expectedResponse), $client->getResponse()
            ->getContent());
    }

    public function testBadRequestException()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/marsclock?utc=111');
        $this->assertEquals(400, $client->getResponse()
            ->getStatusCode());
        $expectedResponse = new \stdClass();
        $expectedResponse->message = "Given Input Date/Time is not valid";
        $this->assertEquals(json_encode($expectedResponse), $client->getResponse()
            ->getContent());
    }

    public function test404Exception()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/marsclock/');
        $this->assertEquals(404, $client->getResponse()
            ->getStatusCode());
    }
}
