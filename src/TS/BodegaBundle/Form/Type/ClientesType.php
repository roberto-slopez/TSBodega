<?php

namespace TS\BodegaBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ClientesType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'TS\BodegaBundle\Model\Clientes',
        'name'       => 'clientes',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombres');
        $builder->add('apellidos');
        $builder->add('nombreCompleto');
        $builder->add('dpi');
        $builder->add('nit');
        $builder->add('telefono');
        $builder->add('direccion');
    }
}
