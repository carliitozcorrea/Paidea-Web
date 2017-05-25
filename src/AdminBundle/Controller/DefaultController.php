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
        $eventManager = $this->get('app.model.event');
        $careerManager = $this->get('app.model.career');
        
        $categorys = $categoryManager->countActive();
        $events = $eventManager->countActive();
        $careers = $careerManager->countActive();
        
        return array(
            'users' => $totalUsers,
            'categorys' => $categorys,
            'events' => $events,
            'careers' => $careers
        );
    }
}
