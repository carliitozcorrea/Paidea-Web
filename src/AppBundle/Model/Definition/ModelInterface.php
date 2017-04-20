<?php
namespace AppBundle\Model\Definition;

use AppBundle\Model\Definition\EntityModelInterface;

/**
 * Description of ModelInterface
 *
 * @author carlos A. Sanchez Correa
 */
interface ModelInterface
{

    const ACTION_READ = 'read';
    const ACTION_UPDATE = 'update';
    const ACTION_CREATE = 'create';
    const ACTION_DELETE = 'delete';

    /**
     * 
     * @param type $status
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function findByStatus($status);

    /**
     * Finds an entity by its primary key / identifier.
     *
     * @param integer $id
     * @return \AppBundle\Model\Definition\AbstractEntityModel
     */
    public function find($id);

    /**
     * Create Entity
     *
     * @return \AppBundle\Model\Definition\EntityModelInterface
     */
    public function createEntity();

    /**
     * Save Entity
     *
     * @param \AppBundle\Model\Definition\EntityModelInterface $entity
     * @return \AppBundle\Model\Definition\EntityModelInterface
     */
    public function save(EntityModelInterface $entity);

    /**
     * Update Entity
     *
     * @param \AppBundle\Model\Definition\EntityModelInterface $entity
     * @return \AppBundle\Model\Definition\EntityModelInterface
     */
    public function update(EntityModelInterface $entity);

    /**
     * Delete Entity
     *
     * @param \AppBundle\Model\Definition\EntityModelInterface $entity
     * @return void
     */
    public function delete(EntityModelInterface $entity);

    /**
     * Authorization
     *
     * @param string $action
     * @return boolean
     */
    public function authorization($action);

    /**
     * Get Simple Name
     *
     * @return string
     */
    public function getName();

    /**
     * @return \Symfony\Component\Security\Core\SecurityContextInterface
     */
    public function getSecurityContext();
}
