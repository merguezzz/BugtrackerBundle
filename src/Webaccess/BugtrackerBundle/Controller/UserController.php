<?php

namespace Webaccess\BugtrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Webaccess\BugtrackerBundle\Entity\User;
use Webaccess\BugtrackerBundle\Utility\Pagination;

class UserController extends Controller
{
	public function indexAction($page_number) {
		$em = $this->getDoctrine()->getEntityManager();
		$repositoryU = $em->getRepository('WebaccessBugtrackerBundle:User');

		$pagination = Pagination::getPagination($page_number, $repositoryU->getTotalNumber(), 10);

        $aParams['users'] = $repositoryU->findBy(array(), array(), $pagination->items_per_page_number, $pagination->items_offset);
		$aParams['pagination'] = $pagination;
		return $this->render('WebaccessBugtrackerBundle:User:index.html.twig', $aParams);
	}

	public function addAction() {
		$em = $this->getDoctrine()->getEntityManager();
		$user = new User();

		$form = $this->createFormBuilder($user)
			->add('username', 'text')
			->add('password', 'password')
			->add('firstName', 'text')
			->add('lastName', 'text')
			->getForm();

		$request = $this->get('request');
		if($request->getMethod() == 'POST') {
			$form->bindRequest($request);
			
			if($form->isValid()) {
				$em->persist($user);
				$em->flush();
				$this->get('session')->setFlash('user_added', 1);

				return $this->redirect($this->generateUrl('webaccess_bugtracker_user'));
			}
		}

		$aParams['form'] = $form->createView();
		return $this->render('WebaccessBugtrackerBundle:User:add.html.twig', $aParams);
	}

	public function editAction($user_id) {
		$em = $this->getDoctrine()->getEntityManager();
		$repositoryU = $em->getRepository('WebaccessBugtrackerBundle:User');
		$user = $repositoryU->find($user_id);

		$form = $this->createFormBuilder($user)
			->add('name', 'text')
			->getForm();

		$request = $this->get('request');
		if($request->getMethod() == 'POST') {
			$form->bindRequest($request);
			
			if($form->isValid()) {
				$em->persist($user);
				$em->flush();
				$this->get('session')->setFlash('user_updated', 1);

				return $this->redirect($this->generateUrl('webaccess_bugtracker_user'));
			}
		}

		$aParams['form'] = $form->createView();
		$aParams['user'] = $user;
		return $this->render('WebaccessBugtrackerBundle:User:edit.html.twig', $aParams);
	}

	public function deleteAction($user_id) {
		$em = $this->getDoctrine()->getEntityManager();
		$repositoryU = $em->getRepository('WebaccessBugtrackerBundle:User');
		$user = $repositoryU->find($user_id);

		try {
			$em->remove($user);
			$em->flush();
			$this->get('session')->setFlash('user_deleted', 1);
		} catch (\Exception $e) {
			$this->get('session')->setFlash('user_error', 1);
		}

		return $this->redirect($this->generateUrl('webaccess_bugtracker_user'));
	}
}