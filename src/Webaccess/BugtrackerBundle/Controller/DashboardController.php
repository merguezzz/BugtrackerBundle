<?php

namespace Webaccess\BugtrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
	public function indexAction($page_number) {
		$aParams['tickets'] = $this->container->get('webaccess_bugtracker.ticket_manager')->getTicketsPaginatedList($page_number);
		$aParams['pagination'] = $this->container->get('webaccess_bugtracker.ticket_manager')->getTicketsPagination($page_number);
		return $this->render('WebaccessBugtrackerBundle:Dashboard:index.html.twig', $aParams);
	}
}
