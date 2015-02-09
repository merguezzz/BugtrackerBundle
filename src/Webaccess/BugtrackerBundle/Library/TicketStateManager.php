<?php

/**
 * TicketStateManager class file
 *
 * PHP 5.3
 *
 * @category Library
 * @package  WebaccessBugtrackerBundle
 * @author   Antonin Jourdan <antonin.jourdan@webcraft-studio.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.webcraft-studio.com
 *
 */
namespace Webaccess\BugtrackerBundle\Library;

use Webaccess\BugtrackerBundle\Entity\Ticket;
use Webaccess\BugtrackerBundle\Entity\TicketState;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * TicketStateManager class
 *
 * @category Library
 * @package  WebaccessBugtrackerBundle
 * @author   Antonin Jourdan <antonin.jourdan@webcraft-studio.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.webcraft-studio.com
 *
 */
class TicketStateManager
{
    protected $em;
    protected $repository;

    /**
     * Constructor
     *
     * @param EntityManager $em          EntityManager
     * @param UserManager   $userManager UserManager
     *
     * @return void
     */
    public function __construct($em, $userManager)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('WebaccessBugtrackerBundle:TicketState');
        $this->repositoryState = $this->em->getRepository('WebaccessBugtrackerBundle:TicketState');
        $this->userManager = $userManager;
    }


    /**
     * Function which creates a ticket
     *
     * @return Ticket
     */
    public function createTicketState(\Webaccess\BugtrackerBundle\Entity\Ticket $ticket)
    {

        $ticket_state = new TicketState();
        $ticket_state->setStatus(3);
        $ticket_state->setPriority(2);
        $ticket_state->setAuthorUser($this->userManager->getUser());
        $ticket_state->setTicket($ticket);
        $ticket->addState($ticket_state);
        $ticket->setCurrentState($ticket_state);

        return $ticket;
    }

    /**
     * Function which saves a ticket in DB
     *
     * @param TicketState $ticketState Ticket State
     *
     * @return void
     */
    public function saveTicketState(\Webaccess\BugtrackerBundle\Entity\TicketState $ticketState)
    {

        $ticket_state = $ticketState;
        $ticket = $ticket_state->getTicket();

        if(!$this->userManager->getUser()->isRole('ROLE_ADMIN')){
            $ticket_state->setAuthorUser($this->userManager->getUser());
        }

        $ticket_state->setTicket($ticket);
        $ticket->addState($ticket_state);
        $ticket->setCurrentState($ticket_state);
        
        $this->em->persist($ticket);
        $this->em->flush();

    }

    /**
     * Function which returns a ticket from DB
     *
     * @param integer $ticketId Ticket ID
     *
     * @return Ticket
     */
    public function getTicketState($ticketState)
    {
        $ticketState = $this->repository->find($tickeStatetId);
        return ($ticketState) ? $ticketState : false;
    }


    /**
     * Function which deletes a ticket in DB
     *
     * @param integer $ticketId Ticket ID
     *
     * @return boolean
     */
    public function deleteTicketState($ticketStateId)
    {
        $ticketState = $this->getTicketState($ticketStateId);
        try {
            $this->em->remove($ticketState);
            $this->em->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
