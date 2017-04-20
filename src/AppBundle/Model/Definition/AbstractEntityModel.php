<?php
namespace AppBundle\Model\Definition;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Status;

/**
 * Description of AbstractEntityModel
 *
 * @author Carlos A. Sánchez Correa
 */
class AbstractEntityModel implements EntityModelInterface
{

    /**
     *
     * @var \AppBundle\Entity\Status
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     * 
     */
    protected $status;

    /**
     *
     * @var \DateTime
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;

    /**
     *
     * @var \DateTime
     * @ORM\Column(name="updated", type="datetime") 
     */
    protected $updated;

    public function __construct()
    {
        $date = new \DateTime();
        $this->setCreated($date);
        $this->setUpdated($date);
    }

    /**
     * {@inheritdoc}
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * 
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * 
     * @param \DateTime $updated
     * @return \CommonBundle\Model\Definition\AbstractEntityModel
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isActive()
    {
        $active = false;
        if (static::STATUS_ACTIVE == $this->getStatus()->getId()) {
            $active = true;
        }

        return $active;
    }

    /**
     * 
     * @return \AppBundle\Entity\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param \AppBundle\Entity\Status $status
     * @return \AppBundle\Model\Definition\AbstractEntityModel
     */
    public function setStatus(Status $status)
    {
        $this->status = $status;
        return $this;
    }
}
