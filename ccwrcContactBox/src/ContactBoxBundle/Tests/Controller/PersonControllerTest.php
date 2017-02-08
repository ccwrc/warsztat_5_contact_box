<?php

namespace ContactBoxBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PersonControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/index');
    }

    public function testDeleteperson()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deletePerson');
    }

    public function testEditperson()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editPerson');
    }

    public function testShowperson()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showPerson');
    }

    public function testShowallpersons()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showAllPersons');
    }

}
