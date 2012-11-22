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
	public function __construct($em) {
        $this->em = $em;
        $this->repository = $this->em->getRepository('WebaccessBugtrackerBundle:Ticket');
	}

    public function getTicketsPaginatedList($page_number) {
        $pagination = $this->getTicketsPagination($page_number);
        return $this->repository->findBy(array(), array(), $pagination->items_per_page_number, $pagination->items_offset);
    }

    public function getTicketsPagination($page_number) {
        return Pagination::getPagination($page_number, $this->repository->getTotalNumber(), 10);
    }

    public function createTicket() {
        $ticket = new Ticket();
        $ticket_state = new TicketState();
        $ticket->addState($ticket_state);
        return $ticket;
    }

    public function saveTicket($ticket) {
        $aStates = $ticket->getStates();
        $ticket_state = $aStates[0];
        $ticket->addState($ticket_state);
        $this->em->persist($ticket_state);
        $this->em->persist($ticket);
        $this->em->flush();
    }

    public function getTicket($ticket_id) {
        $ticket = $this->repository->find($ticket_id);
        return ($ticket) ? $ticket : false;
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
