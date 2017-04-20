<?php
namespace AppBundle\Model\Definition;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Model\Definition\EntityModelInterface;

/**
 * Description of AbstractControllerModel
 *
 * @author carlos A. Sanchez Correa
 */
class AbstractControllerModel extends controller
{

    const LIMIT_PAGE = 25;

    protected $model;
    protected $className;

    /**
     * @route("/active")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function activeAction(Request $request)
    {
        $queryBuilder = $this->getModel()->findByStatus(EntityModelInterface::STATUS_ACTIVE);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(), $request->query->getInt('page', 1), self::LIMIT_PAGE
        );

        return [
            'entities' => $pagination,
            'model' => $this->getModel(),
            'route' => $this->getRequest()->attributes->get('_route'),
        ];
    }

    /**
     * @Route("/inactive")
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function inactiveAction(Request $request)
    {
        $queryBuilder = $this->getModel()->findByStatus(EntityModelInterface::STATUS_INACTIVE);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(), $request->query->getInt('page', 1), self::LIMIT_PAGE
        );

        return [
            'entities' => $pagination,
            'model' => $this->getModel(),
            'route' => $this->getRequest()->attributes->get('_route'),
        ];
    }

    /**
     * @Route("/new")
     * @Template()
     * @return array
     */
    public function newAction(Request $request)
    {
        $entity = $this->getModel()->createEntity();
        $form = $this->createForm($this->createFormType(), $entity, $this->formOptions());

        if ($request->getMethod() == 'POST') {
            $form->submit($request);

            if ($form->isValid()) {
                $this->getModel()->save($entity);

                $uri = 'active';

                if ($request->get('_type') == 'json')
                    return new JsonResponse(['status' => true]);
                else
                    return $this->redirect($uri);
            }
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'model' => $this->getModel(),
            'route' => $this->getRequest()->attributes->get('_route'),
        );
    }

    /**
     *  @return \Symfony\Component\Form\AbstractType
     */
    public function createFormType()
    {
        $className = sprintf('\\AppBundle\\Form\\%sType', $this->getClassName());
        $class = new $className;
        $class->setModel($this->getModel());

        return $class;
    }

    /**
     * @Route("/show/{id}", requirements={"id" = "\d+"})
     * @Method("GET")
     * @Template()
     * @return array
     */
    public function showAction($id)
    {
        $entity = $this->getModel()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        return array(
            'entity' => $entity,
            'model' => $this->getModel(),
        );
    }

    /**
     *
     * @Route("/edit/{id}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function editAction(Request $request, $id)
    {   
        $entity = $this->getModel()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        $editForm = $this->createForm($this->createFormType(), $entity, $this->formOptions());

        if ($request->getMethod() == 'POST') {
            $editForm->submit($request);

            if ($editForm->isValid()) {
                $this->getModel()->update($entity);

                if ($entity->getStatus()->getId() == EntityModelInterface::STATUS_ACTIVE) {
                    $uri = '../active';
                } else {
                    $uri = '../inactive';
                }
                return $this->redirect($uri);
            }
        }

        return array(
            'entity' => $entity,
            'model' => $this->getModel(),
            'form' => $editForm->createView(),
            'route' => $this->getRequest()->attributes->get('_route')
        );
    }

    /**
     * @Route("/toggle/{id}", requirements={"id" = "\d+"}, defaults={"_format"="json"})
     * @Method("POST")
     */
    public function toggleAction($id)
    {
        $entity = $this->getModel()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        $this->getModel()->toggleStatus($entity);

        return new JsonResponse(['status' => 'updated']);
    }

    /**
     *
     * @Route("/delete/{id}", requirements={"id" = "\d+"}, defaults={"_format"="json"})
     * @Method("POST")
     */
    public function deleteAction($id)
    {   
        
        $entity = $this->getModel()->find($id);
        
        if (!$entity || $entity->getStatus()->getId() == EntityModelInterface::STATUS_DELETE) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        $this->getModel()->delete($entity);

        return new JsonResponse(['status' => 'delete']);
    }

    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
    }

    /**
     * @return \CommonBundle\Model\Definition\AbstractModel
     */
    protected function getModel()
    {
        if (empty($this->model)) {
            $this->model = $this->get($this->getModelId());
        }
        return $this->model;
    }

    /**
     * @return string
     */
    protected function getModelId()
    {
        return 'app.model.' . strtolower($this->getClassName());
    }

    /**
     * @return string
     */
    protected function getClassName()
    {
        if (empty($this->className)) {
            $matches = [];
            preg_match('/(?P<class>\w+)Controller$/', get_class($this), $matches);
            $this->className = $matches['class'];
        }

        return $this->className;
    }

    /**
     * @return array
     */
    protected function formOptions()
    {
        return [];
    }
}
