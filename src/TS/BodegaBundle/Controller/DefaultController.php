<?php

namespace TS\BodegaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TSBodegaBundle:Default:index.html.twig',array(
            'nombre' => '',
        ));
    }
}
