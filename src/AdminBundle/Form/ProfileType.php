<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
/**
 * Description of RegistrationType
 *
 * @author Carlos A. Sanchez Correa
 */
class ProfileType extends AbstractType
{
     public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder->add('name',null,array(
            'label' => 'T Nombre',
        ));
    }

    public function getParent()
    {
        return 'fos_user_profile';
    }

    public function getName()
    {
        return 'admin_profile_edit';
    }
}
