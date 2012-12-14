<?php

namespace Webaccess\BugtrackerBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class TicketFilterFormHandler {

    protected $form;
    protected $request;
	protected $session;

    public function __construct(FormInterface $form, Request $request, $session) {
        $this->form = $form;
        $this->request = $request;
        $this->session = $session;
    }

	public function process() {

        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);

            if ($this->form->isValid()) {
                $aTicketFilter = $this->request->request->get('webaccess_bugtracker_ticket_filter');
                $this->session->set('current_project', $aTicketFilter['project']);
                $this->session->set('current_user', $aTicketFilter['user']);
                $this->session->set('current_type', $aTicketFilter['type']);
                $this->session->set('current_status', $aTicketFilter['status']);
                $this->session->set('current_priority', $aTicketFilter['priority']);

                return true;
            }
        }

        return false;
	}
}
