<?php
namespace AppBundle\Model\Definition;

use Doctrine\ORM\Repository;
use AppBundle\Entity\Status;
use Doctrine\ORM\EntityRepository;
/**
 * Description of AbstractRepositoryModel
 *
 * @author Carlos
 */
abstract class AbstractRepositoryModel extends EntityRepository
{

    /**
     * Get Status Reference
     *
     * @param integer $id
     * @return object
     */
    public function getStatusReference($id)
    {
        return $this->getEntityManager()->getReference('AppBundle:Status', $id);
    }

    /**
     * Create Entity
     *
     * @return AppBundle\Model\Definition\AbstractEntityModel
     */
    public function create()
    {
        $class = $this->getEntityName();
        return new $class;
    }

    /**
     * List by Status
     *
     * @param integer $status
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByStatus(Status $status)
    {
        $qb = $this->createQueryBuilder('e');

        $qb
            ->where('e.status = :status')
            ->setParameter(':status', $status)
        ;

        return $qb;
    }

    /**
     * Save Entity
     *
     * @param \AppBundle\Model\Definition\EntityModelInterface $entity
     * @param boolean $flush
     * @return \AppBundle\Model\Definition\EntityModelInterface
     */
    public function save(EntityModelInterface $entity, $flush = true)
    {
        $this->getEntityManager()->persist($entity);

        if (true === $flush) {
            $this->getEntityManager()->flush();
        }

        return $entity;
    }

    /**
     * Update Entity
     *
     * @param \AppBundle\Model\Definition\EntityModelInterface $entity
     * @param boolean $flush
     * @return \AppBundle\Model\Definition\EntityModelInterface
     */
    public function update(EntityModelInterface $entity, $flush = true)
    {
        return $this->save($entity, $flush);
    }

    /**
     * Delete Entity
     *
     * @param \AppBundle\Model\Definition\EntityModelInterface $entity
     * @return void
     */
    public function delete(EntityModelInterface $entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
}
