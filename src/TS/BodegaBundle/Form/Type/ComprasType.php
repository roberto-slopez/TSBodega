<?php

namespace TS\BodegaBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ComprasType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'TS\BodegaBundle\Model\Compras',
        'name'       => 'compras',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('proveedorId');
        $builder->add('inventarioId');
        $builder->add('facturaId');
    }
}
