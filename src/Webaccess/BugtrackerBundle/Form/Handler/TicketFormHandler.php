<?php

namespace Webaccess\BugtrackerBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Webaccess\BugtrackerBundle\Library\TicketManager;

class TicketFormHandler {

    protected $form;
	protected $request;
    protected $ticketManager;

    public function __construct(FormInterface $form, Request $request, TicketManager $ticketManager) {
        $this->form = $form;
        $this->request = $request;
        $this->ticketManager = $ticketManager;
    }

	public function process($ticket) {
        $this->form->setData($ticket);

        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);

            if ($this->form->isValid()) {
                $this->ticketManager->saveTicket($ticket);
                return true;
            }
        }

        return false;
	}
}
