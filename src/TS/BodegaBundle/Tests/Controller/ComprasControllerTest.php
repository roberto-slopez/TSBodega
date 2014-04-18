<?php

namespace TS\BodegaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ComprasControllerTest extends WebTestCase
{
    public function testHomecompras()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/homeCompras');
    }

}
