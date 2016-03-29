<?php

namespace UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ProfileFormType
 *
 * @package UserBundle\Form\Type
 */
class ProfileFormType extends BaseType
{
    /**
     * @param FormBuilderInterface  $builder
     * @param array                 $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('imagen');
        $builder->add('nombre');
        $builder->add('apellidos');
        $builder->add('bio');
        $builder->add(
            'fechaNacimiento',
            'date',
            array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'required' => false,
                'empty_value' => null,
            )
        );
    }

    /**
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return 'fos_user_profile';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user_profile';
    }
}
