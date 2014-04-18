<?php

namespace TS\BodegaBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FacturaDetalleType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'TS\BodegaBundle\Model\FacturaDetalle',
        'name'       => 'facturadetalle',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('facturaId');
        $builder->add('cantidad');
        $builder->add('producto', 'model', array(
           'class' => '\TS\BodegaBundle\Model\Producto',
        ));
        $builder->add('precioUnitario');
        $builder->add('subtotal');
    }
}
