<?php

namespace TS\BodegaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FacturaController extends Controller
{
    public function homeFacturaAction()
    {
        $datos = \TS\BodegaBundle\Model\FacturaQuery::create()->find();

        return $this->render('TSBodegaBundle:Factura:homeFactura.html.twig',array(
            'datos' => $datos,
        ));
    }

    public function newFacturaAction()
    {
        $datos = 'hola';
        return $this->render('TSBodegaBundle:Factura:newFactura.html.twig',array(
            'datos' => $datos,
        ));
    }

    public function imprimeFacturaAction()
    {
    }

}
