<?php

namespace Webaccess\BugtrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
	public function indexAction($page_number) {
		$aParams['tickets'] = $this->container->get('webaccess_bugtracker.ticket_manager')->getTicketsPaginatedList($page_number);
		$aParams['pagination'] = $this->container->get('webaccess_bugtracker.ticket_manager')->getTicketsPagination($page_number);

		$formHandler = $this->container->get('webaccess_bugtracker.switch_project.form_handler');
		if ($projectId = $formHandler->process()) {
			$this->container->get('session')->set('current_project', $projectId);
			return $this->redirect($this->generateUrl('webaccess_bugtracker_dashboard'));
		}
		$this->container->get('session')->set('current_project', NULL);
		return $this->render('WebaccessBugtrackerBundle:Dashboard:index.html.twig', $aParams);
	}

	public function menuAction($route = '') {
		$formSwitchProject = $this->container->get('webaccess_bugtracker.switch_project.form');
		$aParams['formSwitchProject'] = $formSwitchProject->createView();
		$aParams['route'] = $route;
		return $this->render('WebaccessBugtrackerBundle:Includes:menu.html.twig', $aParams);
	}
}
