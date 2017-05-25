<?php
namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use SC\DatetimepickerBundle\Form\Type\DatetimeType;
use AppBundle\Model\Definition\AbstractFormType;
use AppBundle\Model\Definition\EntityModelInterface;

/**
 * Description of CareerType
 *
 * @author Carlos Alberto Sánchez Correa
 */
class CareerType extends AbstractFormType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $fileRequired = true;
//        if ($builder->getData()->getId()) {
//            $fileRequired = false;
//        }
        $builder
            ->add('name', null, [
                'label' => 'career.name',
            ])
            ->add('careerKey', null, [
                'label' => 'career.key',
            ])
        ;
    }
}
