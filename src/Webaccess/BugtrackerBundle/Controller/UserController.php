<?php

namespace Webaccess\BugtrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
	public function indexAction($page_number) {
		$aParams['users'] = $this->container->get('webaccess_bugtracker.user_manager')->getUsersPaginatedList($page_number);
		$aParams['pagination'] = $this->container->get('webaccess_bugtracker.user_manager')->getUsersPagination($page_number);
		return $this->render('WebaccessBugtrackerBundle:User:index.html.twig', $aParams);
	}

	public function addAction() {
		$user = $this->container->get('webaccess_bugtracker.user_manager')->createUser();
		$form = $this->container->get('webaccess_bugtracker.user.form');
		$formHandler = $this->container->get('webaccess_bugtracker.user.form_handler');

        if ($formHandler->process($user)) {
			$this->get('session')->setFlash('user_added', 1);
			return $this->redirect($this->generateUrl('webaccess_bugtracker_user'));
        }
		$aParams['form'] = $form->createView();
		return $this->render('WebaccessBugtrackerBundle:User:add.html.twig', $aParams);
	}

	public function editAction($user_id) {
		$user = $this->container->get('webaccess_bugtracker.user_manager')->getUserById($user_id);
		$form = $this->container->get('webaccess_bugtracker.user.form');
		$formHandler = $this->container->get('webaccess_bugtracker.user.form_handler');

		if ($formHandler->process($user)) {
			$this->get('session')->setFlash('user_updated', 1);
			return $this->redirect($this->generateUrl('webaccess_bugtracker_user'));
		}
		$aParams['form'] = $form->createView();
		$aParams['user'] = $user;
		return $this->render('WebaccessBugtrackerBundle:User:edit.html.twig', $aParams);
	}

	public function deleteAction($user_id) {
		if($this->container->get('webaccess_bugtracker.user_manager')->deleteUser($user_id)) {
            $this->get('session')->setFlash('user_deleted', 1);
		} else {
			$this->get('session')->setFlash('user_error', 1);
		}
		return $this->redirect($this->generateUrl('webaccess_bugtracker_user'));
	}
}
