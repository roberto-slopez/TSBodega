<?php

namespace TS\BodegaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProveedorControllerTest extends WebTestCase
{
    public function testNewproveedor()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'ts_new_proveedor');
    }

    public function testEditproveedor()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'ts_edit_proveedor');
    }

    public function testHomeproveedor()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'ts_home_proveedor');
    }

}
