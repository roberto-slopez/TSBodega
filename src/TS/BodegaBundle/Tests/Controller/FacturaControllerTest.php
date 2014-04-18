<?php

namespace TS\BodegaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FacturaControllerTest extends WebTestCase
{
    public function testHomefactura()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/homeFactura');
    }

    public function testProcesafactura()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/procesaFactura');
    }

    public function testImprimefactura()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/imprimeFactura');
    }

}
