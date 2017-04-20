<?php
namespace AppBundle\Model\Definition;

use AppBundle\Entity\Status;

/**
 * Description of EntityModelInterface
 *
 * @author Carlos A. Sanchez Correa
 */
interface EntityModelInterface
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_DELETE = 3;

    /**
     * 
     * @param \AppBundle\Entity\Status $status
     * @return \AppBundle\Model\Definition\EntityModelInterface
     */
    public function setStatus(Status $status);

    /**
     * @return \AppBundle\Entity\Status
     */
    public function getStatus();

    /**
     * 
     * @param \DateTime $created
     * @return \AppBundle\Model\Definition\EntityModelInterface
     */
    public function setCreated(\DateTime $created);

    /**
     * @return \DateTime
     */
    public function getCreated();

    /**
     * @return boolean
     */
    public function isActive();
}
