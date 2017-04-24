<?php
namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Model\Definition\AbstractFormType;
use AppBundle\Model\Definition\EntityModelInterface;
use AppBundle\Repository\CategoryRepository;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 *
 * @author Carlos Alberto Sanchez Correa
 */
class CategoryType extends AbstractFormType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fileRequired = true;
        if ($builder->getData()->getId()) {
            $fileRequired = false;
        }

        $builder
            ->add('name', null, [
                'label' => 'Nombre  de la Categoria',
            ])
            ->add('file', VichImageType::class, [
                'label' => 'Imagen',
                'required' => $fileRequired,
                'allow_delete' => false, // not mandatory, default is true
                'download_link' => false, // not mandatory, default is true
            ])
        ;
    }
}
