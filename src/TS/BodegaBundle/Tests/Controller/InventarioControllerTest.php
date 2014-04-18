<?php

namespace TS\BodegaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InventarioControllerTest extends WebTestCase
{
    public function testNewinventario()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/newInventario');
    }

    public function testEditinventario()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editInventario');
    }

    public function testHomeinventario()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/homeInventario');
    }

}
