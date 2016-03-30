<?php
/**
 * Created by PhpStorm.
 * User: diegobarrioh
 * Date: 29/3/16
 * Time: 14:47
 */

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GenderType
 *
 * @package UserBundle\Form\Type
 */
class GenderType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                'm' => 'Male',
                'f' => 'Female',
            ),
            'multiple' => false,
            'expanded' => true,
            'translation_domain' => 'forms'
        ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gender';
    }
}