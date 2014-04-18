<?php

namespace TS\BodegaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VentasControllerTest extends WebTestCase
{
    public function testHomeventas()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/homeVentas');
    }

}
