<?php

namespace TS\BodegaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class VentasController extends Controller
{
    public function homeVentasAction()
    {
        $datos = \TS\BodegaBundle\Model\ComprasQuery::create()->find();
        return $this->render('TSBodegaBundle:Ventas:homeVentas.html.twig',array(
            'datos' => $datos,
        ));
    }

}
