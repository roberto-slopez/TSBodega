<?php

namespace TS\BodegaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoriaController extends Controller
{

    public function NewCategoriaAction()
    {
        $categoria = new \TS\BodegaBundle\Model\Categoria();
        $form = $this->createForm(new \TS\BodegaBundle\Form\Type\CategoriaType(), $categoria);

        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $categoria->save();

                return $this->redirect($this->generateUrl('ts_home_categoria'));
            }
        }
        return $this->render('TSBodegaBundle:Categoria:NewCategoria.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function EditCategoriaAction($id)
    {
        $newCategoria = \TS\BodegaBundle\Model\CategoriaQuery::create()->findOneById($id);
        $form = $this->createForm(new \TS\BodegaBundle\Form\Type\CategoriaType(), $newCategoria);
        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $newCategoria->save();
                return $this->redirect($this->generateUrl('ts_home_categoria'));
            }
        }

        return $this->render('TSBodegaBundle:Categoria:EditCategoria.html.twig', array(
            'idCat'=> $id,
            'form' => $form->createView()
        ));
    }

    public function HomeCategoriaAction()
    {
        $datos = \TS\BodegaBundle\Model\CategoriaQuery::create()->find();

        return $this->render('TSBodegaBundle:Categoria:HomeCategoria.html.twig', 
            array( 'datos' => $datos,)
            );
    }
}
