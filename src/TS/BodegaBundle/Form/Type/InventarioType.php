<?php

namespace TS\BodegaBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class InventarioType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'TS\BodegaBundle\Model\Inventario',
        'name'       => 'inventario',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('producto', 'model', array(
           'class' => '\TS\BodegaBundle\Model\Producto',
        ));
        $builder->add('proveedor', 'model', array(
           'class' => '\TS\BodegaBundle\Model\Proveedor',
        ));
        $builder->add('fecha');
        $builder->add('stock');
        $builder->add('neto');
        $builder->add('precioUnitario');
    }
}
