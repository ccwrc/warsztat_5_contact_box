<?php

namespace ContactBoxBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddressControllerTest extends WebTestCase
{
    public function testAddaddress()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addAddress');
    }

    public function testDeleteaddress()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteAddress');
    }

    public function testEditaddress()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editAddress');
    }

}
