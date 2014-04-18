<?php

namespace TS\BodegaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProveedorController extends Controller
{
    public function newProveedorAction()
    {
        $proveedor = new \TS\BodegaBundle\Model\Proveedor();
        $form = $this->createForm(new \TS\BodegaBundle\Form\Type\ProveedorType(), $proveedor);

        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $proveedor->save();
                $this->get('session')->getFlashBag()->add(
                    'exito',
                    'Nuevo proveedor guardado con exito'
                );
                return $this->redirect($this->generateUrl('ts_home_proveedor'));
            }
        }
        return $this->render('TSBodegaBundle:Proveedor:newProveedor.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editProveedorAction($id)
    {
        $editProveedor = \TS\BodegaBundle\Model\ProveedorQuery::create()->findOneById($id);
        $form = $this->createForm(new \TS\BodegaBundle\Form\Type\ProveedorType(), $editProveedor);
        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $editProveedor->save();
                $this->get('session')->getFlashBag()->add(
                    'exito',
                    'El proveedor: '.$editProveedor->getNombre().' se actualizo con exito'
                );
                return $this->redirect($this->generateUrl('ts_home_proveedor'));
            }
        }

        return $this->render('TSBodegaBundle:Proveedor:editProveedor.html.twig', array(
            'idProveedor'=> $id,
            'form' => $form->createView()
        ));
    }

    public function homeProveedorAction()
    {
        $datos = \TS\BodegaBundle\Model\ProveedorQuery::create()->find();
        return $this->render('TSBodegaBundle:Proveedor:homeProveedor.html.twig', 
            array( 'datos' => $datos,)
            );
    }

}
