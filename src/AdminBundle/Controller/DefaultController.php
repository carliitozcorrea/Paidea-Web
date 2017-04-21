<?php
namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="adminhome")
     * @Template("AdminBundle:default:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $totalUsers = $em->getRepository('AppBundle:User')->countUserActive();


        $categoryManager = $this->get('app.model.category');
        $categorys = $categoryManager->countActive();

        return array(
            'users' => $totalUsers,
            'categorys' => $categorys
        );
    }
}
