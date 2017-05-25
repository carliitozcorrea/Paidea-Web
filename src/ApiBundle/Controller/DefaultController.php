<?php
namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AppBundle\Entity\Event;

/**
 * 
 * @author Carlos A.
 */
class DefaultController extends FOSRestController
{

    /**
     * @Rest\View()
     * @Rest\Get("/homeStats")
     */
    public function homeStats()
    {
        $em = $this->getDoctrine()->getManager();
        $categoryManager = $this->get('app.model.category');
        $eventManager = $this->get('app.model.event');
        $careerManager = $this->get('app.model.career');

        $data = array(
            'users' => $totalUsers = $em->getRepository('AppBundle:User')->countUserActive(),
            'categorys' => $categoryManager->countActive(),
            'events' => $events = $eventManager->countActive(),
            'careers' => $events = $careerManager->countActive(),
        );

        $view = $this->view($data);
        return $this->handleView($view);
    }

    /**
     * @Rest\View()
     * @Rest\Get("/user")
     */
    public function userAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $data = array(
            "user" => $user
        );
        $view = $this->view($data);
        return $this->handleView($view);
    }

    /**
     * @Rest\View()
     * @Rest\Get("/events")
     */
    public function eventsAction()
    {
        $qb = $this->getModel('app.model.event')->findByStatus(Event::STATUS_ACTIVE);
        $events = $qb->getQuery()->getResult();

        $data = array(
            "events" => $events
        );
        $view = $this->view($data);
        return $this->handleView($view);
    }

    /**
     * @Rest\View()
     * @Rest\Get("/events/{id}", requirements={"id" = "\d+"})
     */
    public function eventAction($id)
    {
        $event = $this->getModel('app.model.event')->find($id);
        $data = array(
            "event" => $event
        );

        $view = $this->view($data);
        return $this->handleView($view);
    }

    /**
     * @Rest\View()
     * @Rest\Get("/careers") 
     */
    public function careersAction()
    {
        $qb = $this->getModel('app.model.career')->findByStatus(Event::STATUS_ACTIVE);
        $careers = $qb->getQuery()->getResult();

        $data = array(
            "careers" => $careers
        );

        $view = $this->view($data);
        return $this->handleView($view);
    }

    /**
     * Get Model
     *
     * @return \AppBundle\Model\
     */
    protected function getModel($model)
    {
        if (empty($this->model)) {
            $this->model = $this->get($model);
        }

        return $this->model;
    }
}
