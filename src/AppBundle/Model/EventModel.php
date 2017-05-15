<?php
namespace AppBundle\Model;

use AppBundle\Model\Definition\AbstractModel;
use AppBundle\Model\Definition\EntityModelInterface;
/**
 * Description of EventModel
 *
 * @author Carlos A. Sanchez Correa
 */
class EventModel extends AbstractModel
{
    public function save(EntityModelInterface $entity)
    {
        $entity->setUser($this->getUser());
        return parent::save($entity);
    }
}
