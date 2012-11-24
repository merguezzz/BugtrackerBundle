<?php

namespace Webaccess\BugtrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TicketController extends Controller
{
	public function indexAction($page_number) {
		$aParams['tickets'] = $this->container->get('webaccess_bugtracker.ticket_manager')->getTicketsPaginatedList($page_number);
		$aParams['pagination'] = $this->container->get('webaccess_bugtracker.ticket_manager')->getTicketsPagination($page_number);
		return $this->render('WebaccessBugtrackerBundle:Dashboard:index.html.twig', $aParams);
	}

	public function addAction() {
		$ticket = $this->container->get('webaccess_bugtracker.ticket_manager')->createTicket();
		$form = $this->container->get('webaccess_bugtracker.ticket.form');
		$formHandler = $this->container->get('webaccess_bugtracker.ticket.form_handler');

        if ($formHandler->process($ticket)) {
			$this->get('session')->setFlash('ticket_added', 1);
			return $this->redirect($this->generateUrl('webaccess_bugtracker_ticket'));
        }
		$aParams['form'] = $form->createView();
		return $this->render('WebaccessBugtrackerBundle:Ticket:add.html.twig', $aParams);
	}

	public function editAction($ticket_id) {
		$ticket = $this->container->get('webaccess_bugtracker.ticket_manager')->getTicket($ticket_id);
		$ticket_state = $this->container->get('webaccess_bugtracker.ticket_manager')->getLastTicketState($ticket_id);
        $ticket->addState($ticket_state);
		$form = $this->container->get('webaccess_bugtracker.ticket.form');
		$formHandler = $this->container->get('webaccess_bugtracker.ticket.form_handler');

		if ($formHandler->process($ticket, $ticket_state)) {
			$this->get('session')->setFlash('ticket_updated', 1);
			return $this->redirect($this->generateUrl('webaccess_bugtracker_ticket'));
		}
		$aParams['form'] = $form->createView();
		$aParams['ticket'] = $ticket;
		return $this->render('WebaccessBugtrackerBundle:Ticket:edit.html.twig', $aParams);
	}

	public function deleteAction($ticket_id) {
		if($this->container->get('webaccess_bugtracker.ticket_manager')->deleteTicket($ticket_id)) {
            $this->get('session')->setFlash('ticket_deleted', 1);
		} else {
			$this->get('session')->setFlash('ticket_error', 1);
		}
		return $this->redirect($this->generateUrl('webaccess_bugtracker_ticket'));
	}
}
