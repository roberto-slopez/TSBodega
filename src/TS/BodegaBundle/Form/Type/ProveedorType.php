<?php

namespace TS\BodegaBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProveedorType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'TS\BodegaBundle\Model\Proveedor',
        'name'       => 'proveedor',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre');
        $builder->add('encargado');
        $builder->add('nit');
        $builder->add('dpi');
        $builder->add('direccion');
        $builder->add('telefono');
        $builder->add('movil');
    }
}
