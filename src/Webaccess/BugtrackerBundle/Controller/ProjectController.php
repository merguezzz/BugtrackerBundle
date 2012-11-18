<?php

namespace Webaccess\BugtrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Webaccess\BugtrackerBundle\Entity\Project;
use Webaccess\BugtrackerBundle\Utility\Pagination;

class ProjectController extends Controller
{
	public function indexAction($page_number) {
		$em = $this->getDoctrine()->getEntityManager();
		$repositoryP = $em->getRepository('WebaccessBugtrackerBundle:Project');

		$pagination = Pagination::getPagination($page_number, $repositoryP->getTotalNumber(), 10);

		$aParams['projects'] = $repositoryP->findBy(array(), array(), $pagination->items_per_page_number, $pagination->items_offset);
		$aParams['pagination'] = $pagination;
		return $this->render('WebaccessBugtrackerBundle:Project:index.html.twig', $aParams);
	}

	public function addAction() {
		$em = $this->getDoctrine()->getEntityManager();
		$project = new Project();

		$form = $this->createFormBuilder($project)
			->add('name', 'text')
			->add('company', 'entity', array(
				'class' => 'WebaccessBugtrackerBundle:Company',
				'property' => 'name'))
			->getForm();

		$request = $this->get('request');
		if($request->getMethod() == 'POST') {
			$form->bindRequest($request);
			
			if($form->isValid()) {
				$em->persist($project);
				$em->flush();
				$this->get('session')->setFlash('project_added', 1);

				return $this->redirect($this->generateUrl('webaccess_bugtracker_project'));
			}
		}

		$aParams['form'] = $form->createView();
		return $this->render('WebaccessBugtrackerBundle:Project:add.html.twig', $aParams);
	}

	public function editAction($project_id) {
		$em = $this->getDoctrine()->getEntityManager();
		$repositoryP = $em->getRepository('WebaccessBugtrackerBundle:Project');
		$project = $repositoryP->find($project_id);

		$form = $this->createFormBuilder($project)
			->add('name', 'text')
			->add('company', 'entity', array(
				'class' => 'WebaccessBugtrackerBundle:Company',
				'property' => 'name'))
			->getForm();

		$request = $this->get('request');
		if($request->getMethod() == 'POST') {
			$form->bindRequest($request);
			
			if($form->isValid()) {
				$em->persist($project);
				$em->flush();
				$this->get('session')->setFlash('project_updated', 1);

				return $this->redirect($this->generateUrl('webaccess_bugtracker_project'));
			}
		}

		$aParams['form'] = $form->createView();
		$aParams['project'] = $project;
		return $this->render('WebaccessBugtrackerBundle:Project:edit.html.twig', $aParams);
	}

	public function deleteAction($project_id) {
		$em = $this->getDoctrine()->getEntityManager();
		$repositoryP = $em->getRepository('WebaccessBugtrackerBundle:Project');
		$project = $repositoryP->find($project_id);

		try {
			$em->remove($project);
			$em->flush();
			$this->get('session')->setFlash('project_deleted', 1);
		} catch (\Exception $e) {
			$this->get('session')->setFlash('project_error', 1);
		}

		return $this->redirect($this->generateUrl('webaccess_bugtracker_project'));
	}
}