<?php

namespace TS\BodegaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ComprasController extends Controller
{
    public function homeComprasAction()
    {
        $datos = \TS\BodegaBundle\Model\ComprasQuery::create()->find();

        return $this->render('TSBodegaBundle:Compras:homeCompras.html.twig',array(
            'datos' => $datos,
        ));
    }

}
