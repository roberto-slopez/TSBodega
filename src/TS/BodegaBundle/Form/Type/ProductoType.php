<?php

namespace TS\BodegaBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductoType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'TS\BodegaBundle\Model\Producto',
        'name'       => 'producto',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre');
        $builder->add('precio');
        $builder->add('descripcion');
        $builder->add('categoria', 'model', array(
               'class' => '\TS\BodegaBundle\Model\Categoria',
            ));
//        $builder->add('categoria', 'collection', array(
//            'type'          => new \TS\BodegaBundle\Form\Type\CategoriaType(),
//            'allow_add'     => true,
//            'allow_delete'  => true,
//            'by_reference'  => false,
//        ));
    }
}
