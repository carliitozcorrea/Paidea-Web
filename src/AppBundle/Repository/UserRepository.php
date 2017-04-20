<?php
/**
 * User Repository
 *
 * @author Carlos A. Sanchez Correa
 */
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;

class UserRepository extends EntityRepository
{
    /**
     * Find Users by Status
     * @param type $enabled
     * 
     */
    public function findUsersByStatus($enabled = null)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('u')
            ->from('AppBundle:User', 'u')
            ->where('u.enabled = :enabled')
            ->orderBy('u.name', 'ASC')
            ->setParameter('enabled', $enabled);

        $query = $qb->getQuery();

        return $query;
    }
}
