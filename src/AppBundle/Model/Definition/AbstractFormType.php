<?php
namespace AppBundle\Model\Definition;

use Symfony\Component\Form\AbstractType;

/**
 * @author Carlos Alberto Sanchez Correa
 */
abstract class AbstractFormType extends AbstractType implements ModelFormInterface
{

    /**
     * @var \AppBundle\Model\Definition\ModelInterface
     */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function setModel(ModelInterface $model)
    {
        $this->model = $model;

        return $this;
    }
}
