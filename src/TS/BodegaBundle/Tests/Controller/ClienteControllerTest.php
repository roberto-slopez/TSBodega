<?php

namespace TS\BodegaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClienteControllerTest extends WebTestCase
{
    public function testNewcliente()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/NewCliente');
    }

    public function testEditcliente()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/EditCliente');
    }

    public function testHomecliente()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/HomeCliente');
    }

}
