<?php

namespace ContactBoxBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PersonGroupControllerTest extends WebTestCase
{
    public function testAddgroup()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addGroup');
    }

    public function testShowallgroups()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showAllGroups');
    }

    public function testEditgroup()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editGroup');
    }

    public function testDeletegroup()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteGroup');
    }

}
