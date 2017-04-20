<?php
namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\User;
use FOS\UserBundle\Form\Model\ChangePassword;

/**
 * Description of UserController
 * @author Carlos A. Sanchez Correa
 * @Route("/user")
 *
 */
class UserController extends Controller
{

    /**
     * List all active users
     * @Route("/list/active")
     * @Template("AdminBundle:user:index.html.twig")
     */
    public function listActive(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:User')->findUsersByStatus(true);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */ $request->query->getInt('page', 1)/* page number */, 10/* limit per page */
        );

        $route = $this->getRequest()->attributes->get('_route');

        return [
            'users' => $pagination,
            'route' => $route
        ];
    }

    /**
     *
     * List all inactive users
     * @Route("/list/inactive")
     * @Template("AdminBundle:user:index.html.twig")
     */
    public function listInactive(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('AppBundle:User')->findUsersByStatus(false);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */ $request->query->getInt('page', 1)/* page number */, 10/* limit per page */
        );

        $route = $this->getRequest()->attributes->get('_route');

        return [
            'users' => $pagination,
            'route' => $route
        ];
    }

    /**
     *
     * @Route("/new")
     * @Template("AdminBundle:user:new.html.twig")
     */
    public function newAction(Request $request)
    {

        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager = $this->container->get('fos_user.user_manager');
            $user->setEnabled(true);
            $userManager->updateUser($user);
            return $this->redirectToRoute('admin_user_listactive');
        }
        return[
            'user' => $user,
            'form' => $form->createView(),
        ];
    }

    /**
     *
     * @Route("/toggle/{id}", requirements={"id" = "\d+"})
     * @paramConverter ("user", class="AppBundle:User")
     */
    public function toogleAction(User $user)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user->setEnabled(!$user->isEnabled());
        $userManager->updateUser($user);

        if ($user->isEnabled()) {
            return $this->redirectToRoute('admin_user_listinactive');
        } else {
            return $this->redirectToRoute('admin_user_listactive');
        }
    }

    /**
     * @Route("/edit/{id}", requirements={"id" = "\d+"})
     * @paramConverter ("user", class="AppBundle:User")
     * * @Template("AdminBundle:user:edit.html.twig")
     */
    public function editAction(User $user, Request $request)
    {
        $route = $this->getRequest()->attributes->get('_route');
        $form = $this->createForm('AppBundle\Form\EditType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager = $this->container->get('fos_user.user_manager');
            $userManager->updateUser($user);

            if ($user->isEnabled()) {
                return $this->redirectToRoute('admin_user_listactive');
            } else {
                return $this->redirectToRoute('admin_user_listinactive');
            }
        }
        return[
            'user' => $user,
            'form' => $form->createView(),
            'route' => $route,
        ];
    }

    /**
     * @Route("edit/password/{id}", requirements={"id" = "\d+"})
     * @paramConverter ("user", class="AppBundle:User")
     * @Template("AdminBundle:user:edit.html.twig")
     */
    public function changePasswordAction(User $user, Request $request)
    {
        $changePass = new ChangePassword();

        $route = $this->getRequest()->attributes->get('_route');
        $form = $this->createForm('AppBundle\Form\ChangePasswordType', $changePass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager = $this->container->get('fos_user.user_manager');
            $user->setPlainPassword($changePass->new);
            $userManager->updateUser($user);

            if ($user->isEnabled()) {
                return $this->redirectToRoute('admin_user_listactive');
            } else {
                return $this->redirectToRoute('admin_user_listinactive');
            }
        }
        return[
            'user' => $user,
            'form' => $form->createView(),
            'route' => $route
        ];
    }
}
