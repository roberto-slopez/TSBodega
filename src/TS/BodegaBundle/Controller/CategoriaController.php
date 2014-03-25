<?php

namespace TS\BodegaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoriaController extends Controller
{

    public function NewCategoriaAction()
    {
    }

    public function EditCategoriaAction()
    {
    }

    public function HomeCategoriaAction()
    {
        return $this->render('TSBodegaBundle:Categoria:HomeCategoria.html.twig',array(
            'nombre' => '',
        ));
    }
}
