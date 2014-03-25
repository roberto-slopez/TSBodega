<?php

namespace TS\BodegaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductoController extends Controller
{
    public function NewProductoAction()
    {
    }

    public function EditProductoAction()
    {
    }

    public function HomeProductoAction()
    {
        return $this->render('TSBodegaBundle:Producto:HomeProducto.html.twig',array(
            'nombre' => '',
        ));
    }
}
