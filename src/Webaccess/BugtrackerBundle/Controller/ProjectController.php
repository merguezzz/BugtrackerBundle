<?php

namespace Webaccess\BugtrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProjectController extends Controller
{
	public function indexAction($page_number) {
		$aParams['projects'] = $this->container->get('webaccess_bugtracker.project_manager')->getProjectsPaginatedList($page_number);
		$aParams['pagination'] = $this->container->get('webaccess_bugtracker.project_manager')->getProjectsPagination($page_number);
		return $this->render('WebaccessBugtrackerBundle:Project:index.html.twig', $aParams);
	}

	public function addAction() {
		$project = $this->container->get('webaccess_bugtracker.project_manager')->createProject();
		$form = $this->container->get('webaccess_bugtracker.project.form');
		$formHandler = $this->container->get('webaccess_bugtracker.project.form_handler');

        if ($formHandler->process($project)) {
			$this->get('session')->setFlash('project_added', 1);
			return $this->redirect($this->generateUrl('webaccess_bugtracker_project'));
        }
		$aParams['form'] = $form->createView();
		return $this->render('WebaccessBugtrackerBundle:Project:add.html.twig', $aParams);
	}

	public function editAction($project_id) {
		$project = $this->container->get('webaccess_bugtracker.project_manager')->getProject($project_id);
		$form = $this->container->get('webaccess_bugtracker.project.form');
		$formHandler = $this->container->get('webaccess_bugtracker.project.form_handler');

		if ($formHandler->process($project)) {
			$this->get('session')->setFlash('project_updated', 1);
			return $this->redirect($this->generateUrl('webaccess_bugtracker_project'));
		}
		$aParams['form'] = $form->createView();
		$aParams['project'] = $project;
		return $this->render('WebaccessBugtrackerBundle:Project:edit.html.twig', $aParams);
	}

	public function deleteAction($project_id) {
		if($this->container->get('webaccess_bugtracker.project_manager')->deleteProject($project_id)) {
            $this->get('session')->setFlash('project_deleted', 1);
		} else {
			$this->get('session')->setFlash('project_error', 1);
		}
		return $this->redirect($this->generateUrl('webaccess_bugtracker_project'));
	}
}
