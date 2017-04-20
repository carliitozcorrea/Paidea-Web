<?php
namespace AppBundle\Model\Definition;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use AppBundle\Model\Definition\EntityModelInterface;

/**
 * Description of AbstractModel
 *
 * @author carlos
 */
abstract class AbstractModel extends ContainerAware implements ModelInterface
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \AppBundle\Model\Definition\AbstractRepositoryModel
     */
    protected $repository;

    /**
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var string
     */
    protected $name;

    /**
     *
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $container
     * @param \Doctrine\ORM\EntityManager $em
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $securityContext
     * @param string $class
     */
    public function __construct(ContainerInterface $container, EntityManager $em, SecurityContextInterface $securityContext, $class = '')
    {
        if (empty($class)) {
            $matches = '';
            preg_match('/(?P<class>\w+)Model$/', get_class($this), $matches);
            $class = 'AppBundle:' . $matches['class'];
        }

        $metadata = $em->getClassMetadata($class);
        $this->em = $em;
        $this->securityContext = $securityContext;
        $this->class = $metadata->name;
        $this->name = strtolower($matches['class']);
        $this->repository = $em->getRepository($class);
        $this->setContainer($container);
    }

    /**
     * Get Repository
     *
     * @return \AppBundle\Model\Definition\AbstractRepositoryModel
     */
    public function getRepository($name = null)
    {
        $repository = $this->repository;

        if (!is_null($name)) {
            $repository = $this->container->get('doctrine')->getManager()->getRepository($name);
        }

        return $repository;
    }

    /**
     * {@inheritdoc }
     */
    public function createEntity()
    {
        $entity = $this->getRepository()->create();
        $entity->setStatus($this->em->getReference('AppBundle:Status', EntityModelInterface::STATUS_ACTIVE));
        return $entity;
    }

    /**
     * {@inheritdoc }
     */
    public function delete(EntityModelInterface $entity)
    {
        $status = $this->em->getReference('AppBundle:Status', EntityModelInterface::STATUS_DELETE);
        $entity->setStatus($status);
        
        $this->update($entity);
        
        return $entity;
    }

    /**
     * Find entities by status
     *
     * @param integer $status
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByStatus($status, $parent = null)
    {
        $entityStatus = $this->em->getReference('AppBundle:Status', $status);
        return $this->getRepository()->findByStatus($entityStatus, $parent);
    }

    /**
     * {@inheritdoc }
     */
    public function find($id)
    {
        if (is_null($id)) {
            return null;
        }

        $entity = $this->getRepository()->find($id);

        if ($entity->getStatus()->getId() == EntityModelInterface::STATUS_DELETE) {
            return null;
        }

        return $entity;
    }

    /**
     * {@inheritdoc }
     */
    public function save(EntityModelInterface $entity)
    {
        return $this->getRepository()->save($entity);
    }

    /**
     * {@inheritdoc }
     */
    public function update(EntityModelInterface $entity)
    {
        return $this->getRepository()->update($entity);
    }

    /**
     * Cambia el estado de una entidad entre activa e inactiva
     *
     * @param AppBundle\Model\Definition\AbstractEntityModel $entity
     * @return AppBundle\Model\Definition\AbstractEntityModel
     */
    public function toggleStatus(EntityModelInterface $entity)
    {
        if ($entity->getStatus()->getId() == EntityModelInterface::STATUS_DELETE) {
            throw new Exception('Error Entity Found');
        }

        if ($entity->getStatus()->getId() == EntityModelInterface::STATUS_ACTIVE) {
            $status = $this->em->getReference('AppBundle:Status', EntityModelInterface::STATUS_INACTIVE);
            $entity->setStatus($status);
        } else {
            $status = $this->em->getReference('AppBundle:Status', EntityModelInterface::STATUS_ACTIVE);
            $entity->setStatus($status);
        }

        $this->update($entity);

        return $entity;
    }

    /**
     * Get a user from the Security Token Storage.
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     */
    public function getUser()
    {
        if (!$this->container->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return;
        }

        return $user;
    }

    /**
     * Checks if the attributes are granted against the current authentication token and optionally supplied object.
     *
     * @param mixed $attributes The attributes
     * @param mixed $object     The object
     *
     * @return bool
     *
     * @throws \LogicException
     */
    protected function isGranted($attributes, $object = null)
    {
        if (!$this->container->has('security.authorization_checker')) {
            throw new \LogicException('The SecurityBundle is not registered in your application.');
        }

        return $this->container->get('security.authorization_checker')->isGranted($attributes, $object);
    }

    /**
     * {@inheritdoc }
     */
    public function authorization($action)
    {
        throw new Exception('@TODO AUTORIZATION CHECK');
    }

    /**
     * {@inheritdoc }
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc }
     */
    public function getSecurityContext()
    {
        return $this->securityContext;
    }
}
