<?php

namespace TS\BodegaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductoControllerTest extends WebTestCase
{
    public function testNewcategoria()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/NewCategoria');
    }

    public function testEditcategoria()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/EditCategoria');
    }

    public function testHomecategoria()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/HomeCategoria');
    }

}
