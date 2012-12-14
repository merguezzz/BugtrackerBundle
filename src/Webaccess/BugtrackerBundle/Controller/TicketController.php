<?php

namespace Webaccess\BugtrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TicketController extends Controller
{
	public function menuAction($route = '') {
		$aParams['route'] = $route;
		return $this->render('WebaccessBugtrackerBundle:Includes:menu.html.twig', $aParams);
	}

	public function switchLanguageAction($lang = null) {
		if($lang != null) {
		    $this->get('request')->setLocale($lang);
		}
	    return $this->redirect($this->generateUrl('webaccess_bugtracker_ticket', array('_locale'=> $this->get('request')->getLocale())));
	}

	public function indexAction($page_number) {
		$formTicketFilter = $this->container->get('webaccess_bugtracker.ticket_filter.form');
		$formHandlerTicketFilter = $this->container->get('webaccess_bugtracker.ticket_filter.form_handler');

		if ($formHandlerTicketFilter->process()) {
			return $this->redirect($this->generateUrl('webaccess_bugtracker_ticket'));
		}

		$aParams['tickets'] = $this->container->get('webaccess_bugtracker.ticket_manager')->getTicketsPaginatedList($page_number);
		$aParams['pagination'] = $this->container->get('webaccess_bugtracker.ticket_manager')->getTicketsPagination($page_number);
		$aParams['formTicketFilter'] = $formTicketFilter->createView();
		return $this->render('WebaccessBugtrackerBundle:Ticket:index.html.twig', $aParams);
	}

	public function addAction() {
		$ticket = $this->container->get('webaccess_bugtracker.ticket_manager')->createTicket();
		$form = $this->container->get('webaccess_bugtracker.ticket.form');
		$formHandler = $this->container->get('webaccess_bugtracker.ticket.form_handler');

        if ($formHandler->process($ticket)) {
			$this->get('session')->setFlash('ticket_added', 1);
			$this->get('session')->setFlash('last_ticket', $ticket->getId());

			/*$message = \Swift_Message::newInstance()
                ->setSubject('[Bugtracker - ' . $ticket->getProject()->getName(). '] Un nouveau ticket a été créé')
                ->setFrom('bugtracker@web-access.fr')
                ->setTo($ticket->getStates()->last()->getAllocatedUser()->getEmail())
                ->setBody($this->renderView('WebaccessBugtrackerBundle:Mail:ticket_add.html.twig'), 'text/html');
            $this->get('mailer')->send($message);*/

			return $this->redirect($this->generateUrl('webaccess_bugtracker_ticket'));
        }
		$aParams['form'] = $form->createView();
		return $this->render('WebaccessBugtrackerBundle:Ticket:add.html.twig', $aParams);
	}

	public function editAction($ticket_id) {
		$ticket = $this->container->get('webaccess_bugtracker.ticket_manager')->getTicket($ticket_id);
		$form = $this->container->get('webaccess_bugtracker.ticket.form');
		$formHandler = $this->container->get('webaccess_bugtracker.ticket.form_handler');

		if ($formHandler->process($ticket)) {
			$this->get('session')->setFlash('ticket_updated', 1);
			$this->get('session')->setFlash('last_ticket', $ticket->getId());

			/*$message = \Swift_Message::newInstance();
			$image_logo = $message->embed(\Swift_Image::fromPath(__DIR__ . '/../Resources/public/images/logo.png'));
            $message->setSubject('[Bugtracker - ' . $ticket->getProject()->getName(). '] Un nouveau ticket a été édité')
                ->setFrom('bugtracker@web-access.fr')
                ->setTo($ticket->getStates()->last()->getAllocatedUser()->getEmail())
                ->setBody($this->renderView('WebaccessBugtrackerBundle:Mail:ticket_edit.html.twig', array('image_logo' => $image_logo)), 'text/html');
            $this->get('mailer')->send($message);*/

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

	public function testMailAction() {
		$message = \Swift_Message::newInstance();
		$aParams['image_logo'] = '/bundles/webaccessbugtracker/images/logo.png';
		return $this->render('WebaccessBugtrackerBundle:Mail:ticket_edit.html.twig', $aParams);
	}
}
