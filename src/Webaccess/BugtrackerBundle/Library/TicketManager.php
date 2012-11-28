<?php

namespace Webaccess\BugtrackerBundle\Library;

use Webaccess\BugtrackerBundle\Utility\Pagination;
use Webaccess\BugtrackerBundle\Entity\Ticket;
use Webaccess\BugtrackerBundle\Entity\TicketState;

class TicketManager {

    protected $em;
    protected $repository;

    /**
     * Constructor
     *
     * @param Entity manager $em
     */
	public function __construct($em, $userManager) {
        $this->em = $em;
        $this->repository = $this->em->getRepository('WebaccessBugtrackerBundle:Ticket');
        $this->repositoryState = $this->em->getRepository('WebaccessBugtrackerBundle:TicketState');
        $this->userManager = $userManager;
	}

    public function getTicketsPaginatedList($page_number) {
        $pagination = $this->getTicketsPagination($page_number);
        return $this->repository->getByUser($this->userManager->getUserInSession()->getId(), ($this->userManager->getProjectInSession() ? $this->userManager->getProjectInSession()->getId() : NULL),$pagination->items_per_page_number, $pagination->items_offset);
    }

    public function getTicketsPagination($page_number) {
        return Pagination::getPagination($page_number, $this->repository->getTotalNumber(), 10);
    }

    public function createTicket() {
        $ticket = new Ticket();
        $ticket_state = new TicketState();
        $ticket_state->setTicket($ticket);
        $ticket->addState($ticket_state);
        return $ticket;
    }

    public function saveTicket($ticket) {
        $aStates = $ticket->getStates();
        $ticket_state = $aStates[sizeof($aStates) - 1];
        $ticket->addState($ticket_state);
        $ticket_state->setTicket($ticket);
        $this->em->persist($ticket_state);
        $this->em->persist($ticket);
        $this->em->flush();
    }

    public function getTicket($ticket_id) {
        $ticket = $this->repository->find($ticket_id);
        $ticket_state = $this->getLastTicketState($ticket_id);
        $ticket->addState($ticket_state);
        return ($ticket) ? $ticket : false;
    }

    public function getLastTicketState($ticket_id) {
        $ticket = $this->repository->find($ticket_id);
        $last_ticket_state = $this->repositoryState->findLastStateOfTicket($ticket->getId());
        $ticket_state = new TicketState();
        $ticket_state->setAuthorUser($this->userManager->getUserInSession());
        $ticket_state->setAllocatedUser($last_ticket_state->getAllocatedUser());
        $ticket_state->setType($last_ticket_state->getType());
        $ticket_state->setStatus($last_ticket_state->getStatus());
        $ticket_state->setPriority($last_ticket_state->getPriority());
        $ticket_state->setTicket($ticket);
        return ($ticket_state) ? $ticket_state : false;
    }

    public function deleteTicket($ticket_id) {
        $ticket = $this->getTicket($ticket_id);
        try {
            $this->em->remove($ticket);
            $this->em->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
