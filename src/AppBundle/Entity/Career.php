<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use AppBundle\Model\Definition\AbstractEntityModel;
use AppBundle\Entity\User;

/**
 * Career
 *
 * @ORM\Table(name="career")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CareerRepository")
 */
class Career extends AbstractEntityModel
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="careerKey", type="string", length=255)
     */
    private $careerKey;

    /**
     *
     * @var \AppBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Career
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set careerKey
     *
     * @param string $careerKey
     *
     * @return Career
     */
    public function setCareerKey($careerKey)
    {
        $this->careerKey = $careerKey;

        return $this;
    }

    /**
     * Get careerKey
     *
     * @return string
     */
    public function getCareerKey()
    {
        return $this->careerKey;
    }

    /**
     * 
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * 
     * @param \AppBundle\Entity\User $user
     * @return \AppBundle\Entity\Career
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
}
