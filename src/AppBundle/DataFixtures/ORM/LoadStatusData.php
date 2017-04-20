<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Model\Definition\EntityModelInterface;
use AppBundle\Entity\Status;

/**
 * Description of LoadStatusData
 *
 * @author Carlos A. Sanchez Correa
 */
class LoadStatusData implements FixtureInterface
{

    /**
     *
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $manager;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        /**
         * Create Status
         */
        $this->createStatus(EntityModelInterface::STATUS_ACTIVE, 'active');
        $this->createStatus(EntityModelInterface::STATUS_INACTIVE, 'inactive');
        $this->createStatus(EntityModelInterface::STATUS_DELETE, 'delete');
    }

    /**
     * 
     * @param integer $id
     * @param string $name
     */
    public function createStatus($id, $name)
    {
        $status = new Status();

        $status->setId($id);
        $status->setName($name);

        $this->manager->persist($status);
        $this->manager->flush();
    }
}
