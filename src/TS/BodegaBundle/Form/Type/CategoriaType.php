<?php

namespace TS\BodegaBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoriaType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'TS\BodegaBundle\Model\Categoria',
        'name'       => 'categoria',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre');
        $builder->add('descripcion');
    }
}
