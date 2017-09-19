<?php
namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Description of UserController
 *
 * @author Carlos A.
 */
class UserController extends FOSRestController
{

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
}
