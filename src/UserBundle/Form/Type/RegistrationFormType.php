<?php
/**
 * Created by PhpStorm.
 * User: diegobarrioh
 * Date: 07/11/14
 * Time: 08:17
 */

namespace UserBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RegistrationFormType
 *
 * @package UserBundle\Form\Type
 */
class RegistrationFormType extends BaseType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // add your custom field
        $builder->add('nombre');
        $builder->add('apellidos');
        $builder->add(
            'fechaNacimiento',
            'date',
            array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'required' => false
            )
        );
    }

    /**
     * @return null|string|\Symfony\Component\Form\FormTypeInterface
     */
    public function getParent()
    {
        return 'fos_user_registration';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user_registration';
    }
}
