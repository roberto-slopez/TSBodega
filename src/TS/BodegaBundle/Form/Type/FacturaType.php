<?php

namespace TS\BodegaBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FacturaType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'TS\BodegaBundle\Model\Factura',
        'name'       => 'factura',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tipo');
        $builder->add('clientes', 'model', array(
           'class' => '\TS\BodegaBundle\Model\Clientes',
        ));
        $builder->add('subtotal');
        $builder->add('impuesto');
        $builder->add('descuento');
        $builder->add('total');
    }
}
