<?php
namespace AppBundle\Model;

use AppBundle\Model\Definition\AbstractModel;
use AppBundle\Model\Definition\EntityModelInterface;

/**
 * Description of CategoryModel
 *
 * @author Carlos A.
 */
class CareerModel extends AbstractModel
{

    public function save(EntityModelInterface $entity)
    {
        $entity->setUser($this->getUser());
        return parent::save($entity);
    }
}
