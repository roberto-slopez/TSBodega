<?php

namespace TS\BodegaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoriaControllerTest extends WebTestCase
{
    public function testNewproducto()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/NewProducto');
    }

    public function testEditproducto()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/EditProducto');
    }

    public function testHomeproducto()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/HomeProducto');
    }

}
