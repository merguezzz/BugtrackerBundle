<?php

/**
 * TicketFormHandler class file
 *
 * PHP 5.3
 *
 * @category FormHandler
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
namespace Webaccess\BugtrackerBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Webaccess\BugtrackerBundle\Library\TicketManager;

/**
 * TicketFormHandler class
 *
 * @category FormHandler
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class TicketFormHandler
{
    protected $form;
    protected $request;
    protected $ticketManager;

    /**
     * Constructor
     *
     * @param FormInterface $form          FormInterface
     * @param Request       $request       Request
     * @param TicketManager $ticketManager TicketManager
     *
     * @return void
     */
    public function __construct(FormInterface $form, Request $request, TicketManager $ticketManager)
    {
        $this->form = $form;
        $this->request = $request;
        $this->ticketManager = $ticketManager;
    }

    /**
     * Function that handle the Ticket form submission
     *
     * @param Ticket $ticket Ticket to be processed
     *
     * @return boolean
     */
    public function process($ticket)
    {
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
