<?php
namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * 
 * @author Carlos A.
 */
class DefaultController extends FOSRestController
{

    /**
     * @Rest\View()
     * @Rest\Get("/test")
     */
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $data = array(
            "user" => $user
        );
        $view = $this->view($data);
        return $this->handleView($view);
    }
}
