<?php
namespace AdminBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\BrowserKit\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Model\Definition\AbstractControllerModel;

/**
 * Description of EventController
 * 
 * @author carlos A. Sanchez Correa
 */

/**
 * @Route("/event", name="event")
 * @Security("has_role('ROLE_USER')")
 */
class EventController extends AbstractControllerModel
{
    
}
