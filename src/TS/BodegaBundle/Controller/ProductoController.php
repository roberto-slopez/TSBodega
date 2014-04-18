<?php

namespace TS\BodegaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductoController extends Controller
{
    public function NewProductoAction()
    {
        $producto = new \TS\BodegaBundle\Model\Producto();
        $form = $this->createForm(new \TS\BodegaBundle\Form\Type\ProductoType(), $producto);

        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $producto->save();
                $this->get('session')->getFlashBag()->add(
                    'exito',
                    'Nuevo producto guardada con exito'
                );
                return $this->redirect($this->generateUrl('ts_home_producto'));
            }
        }
        return $this->render('TSBodegaBundle:Producto:NewProducto.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function EditProductoAction($id)
    {
        $editProducto = \TS\BodegaBundle\Model\ProductoQuery::create()->findOneById($id);
        $form = $this->createForm(new \TS\BodegaBundle\Form\Type\ProductoType(), $editProducto);
        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $editProducto->save();
                $this->get('session')->getFlashBag()->add(
                    'exito',
                    'El producto: '.$editProducto->getNombre().' se actualizo con exito'
                );
                return $this->redirect($this->generateUrl('ts_home_producto'));
            }
        }

        return $this->render('TSBodegaBundle:Producto:EditProducto.html.twig', array(
            'idProduct'=> $id,
            'form' => $form->createView()
        ));
    }

    public function HomeProductoAction()
    {
        $datos = \TS\BodegaBundle\Model\ProductoQuery::create()->find();

        return $this->render('TSBodegaBundle:Producto:HomeProducto.html.twig',array(
            'datos' => $datos,
        ));
    }
}
