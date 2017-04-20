<?php

namespace AppBundle\Model\Definition;


/**
 * @author Carlos Alberto Sanchez Correa
 * 
 */
interface ModelFormInterface
{
    /**
     * Set Model
     *
     * @param \AppBundle\Model\Definition\ModelInterface $model
     * @return \AppBundle\Model\Definition\ModelFormInterface
     */
    public function setModel(ModelInterface $model);
}