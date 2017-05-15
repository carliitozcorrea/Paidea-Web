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
use AppBundle\Repository\CategoryRepository;

/**
 * Description of EventType
 *
 * @author Carlos Alberto Sánchez Correa
 */
class EventType extends AbstractFormType
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
                'label' => 'event.name',
            ])
            ->add('type', null, [
                'label' => 'event.type',
                'query_builder' => function (CategoryRepository $er) {
                    $status = $er->getStatusReference(EntityModelInterface::STATUS_ACTIVE);
                    return $er->findByStatus($status);
                },
            ])
            ->add('file', VichImageType::class, [
                'label' => 'Imagen',
                'required' => false,
                'allow_delete' => false, // not mandatory, default is true
                'download_link' => false, // not mandatory, default is true
                'required' => $fileRequired
            ])
            ->add('responsible', null, [
                'label' => 'event.responsible',
            ])
            ->add('responsibleEco', null, [
                'label' => 'event.responsible.eco',
            ])
            ->add('place', TextareaType::class, [
                'label' => 'event.place',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'event.description',
            ])
            ->add('startDate', DatetimeType::class, array(
                'label' => 'event.start',
                'pickerOptions' => array(
                    'format' => 'dd-MM-yyyy - hh:ii',
                    'startDate' => date('d/m/Y - H:i'),
                    'autoclose' => true,
                    'todayBtn' => true,
                    'todayHighlight' => true,
                    'pickerPosition' => 'bottom-left',
                )
            ))
            ->add('endDate', DatetimeType::class, array(
                'label' => 'event.start',
                'pickerOptions' => array(
                    'format' => 'dd-MM-yyyy - hh:ii',
                    'startDate' => date('d/m/Y - H:i'),
                    'autoclose' => true,
                    'todayBtn' => true,
                    'todayHighlight' => true,
                    'pickerPosition' => 'bottom-left',
                )
            ))
        ;
    }
}
