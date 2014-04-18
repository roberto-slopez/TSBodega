<?php

namespace TS\BodegaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClienteController extends Controller
{
    public function NewClienteAction()
    {
        $cliente = new \TS\BodegaBundle\Model\Clientes();
        $form = $this->createForm(new \TS\BodegaBundle\Form\Type\ClientesType(), $cliente);

        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $cliente->save();
                $this->get('session')->getFlashBag()->add(
                    'exito',
                    'Nuevo cliente guardado con exito'
                );
                return $this->redirect($this->generateUrl('ts_home_cliente'));
            }
        }
        return $this->render('TSBodegaBundle:Cliente:NewCliente.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function EditClienteAction($id)
    {
        $newCliente = \TS\BodegaBundle\Model\ClientesQuery::create()->findOneById($id);
        $form = $this->createForm(new \TS\BodegaBundle\Form\Type\ClientesType(), $newCliente);
        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $newCliente->save();
                $this->get('session')->getFlashBag()->add(
                    'exito',
                    'El Cliente: '.$newCliente->getNombreCompleto().' se actualizo con exito'
                );
                return $this->redirect($this->generateUrl('ts_home_cliente'));
            }
        }

        return $this->render('TSBodegaBundle:Cliente:EditCliente.html.twig', array(
            'idClient'=> $id,
            'form' => $form->createView()
        ));
    }

    public function HomeClienteAction()
    {
        $datos = \TS\BodegaBundle\Model\ClientesQuery::create()->find();

        return $this->render('TSBodegaBundle:Cliente:HomeCliente.html.twig',array(
            'datos' => $datos,
        ));
    }
}
