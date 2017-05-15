<?php
namespace AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use JMS\Serializer\Annotation as JMS;
use AppBundle\Model\Definition\AbstractEntityModel;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @Vich\Uploadable
 */
class Category extends AbstractEntityModel
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
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     *
     * @Vich\UploadableField(mapping="category_image", fileNameProperty="image")
     * @var \Symfony\Component\HttpFoundation\File\File
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Category
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
     * 
     * @return \Symfony\Component\HttpFoundation\File\File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * 
     * @param \Symfony\Component\HttpFoundation\File\File $file
     * @return \AppBundle\Entity\Category
     */
    public function setFile(File $file)
    {
        $this->file = $file;
        if ($file) {
            $this->setUpdated(new \DateTime('now'));
        }
        return $this;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return \AppBundle\Entity\Category
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
