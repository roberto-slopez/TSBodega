<?php

namespace TS\BodegaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClienteController extends Controller
{
    public function NewClienteAction()
    {
    }

    public function EditClienteAction()
    {
    }

    public function HomeClienteAction()
    {
        return $this->render('TSBodegaBundle:Cliente:HomeCliente.html.twig',array(
            'nombre' => '',
        ));
    }

}
