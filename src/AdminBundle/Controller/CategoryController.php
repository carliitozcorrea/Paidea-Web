<?php
namespace AdminBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\BrowserKit\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Model\Definition\AbstractControllerModel;

/**
 * Description of CategoryController
 *
 * @author carlos A. Sanchez Correa
 */

/**
 * @Route("/category", name="categoryz")
 * @Security("has_role('ROLE_USER')")
 */
class CategoryController extends AbstractControllerModel
{
    
}
