<?php

namespace TS\BodegaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InventarioController extends Controller
{
    public function newInventarioAction()
    {
    }

    public function editInventarioAction()
    {
    }

    public function homeInventarioAction()
    {
        $datos = \TS\BodegaBundle\Model\InventarioQuery::create()->find();
        return $this->render('TSBodegaBundle:Inventario:homeInventario.html.twig', 
            array( 'datos' => $datos,)
            );
    }

}
