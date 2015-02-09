<?php

/**
 * TicketStateFormHandler class file
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
use Webaccess\BugtrackerBundle\Library\TicketStateManager;

/**
 * TicketStateFormHandler class
 *
 * @category FormHandler
 * @package  WebaccessBugtrackerBundle
 * @author   Antonin Jourdan <antonin.jourdan@webcraft-studio.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.webcraft-studio.com
 *
 */
class TicketStateFormHandler
{
    protected $form;
    protected $request;
    protected $ticketStateManager;

    /**
     * Constructor
     *
     * @param FormInterface $form          FormInterface
     * @param Request       $request       Request
     * @param TicketStateManager $ticketStateManager TicketStateManager
     *
     * @return void
     */
    public function __construct(FormInterface $form, Request $request, TicketStateManager $ticketStateManager)
    {
        $this->form = $form;
        $this->request = $request;
        $this->ticketStateManager = $ticketStateManager;
    }

    /**
     * Function that handle the Ticket State form submission
     *
     * @param TicketState $ticketState Ticket State to be processed
     *
     * @return boolean
     */
    public function process($ticketState)
    {

        $this->form->setData($ticketState);

        if ('POST' === $this->request->getMethod()) {

            $this->form->bind($this->request);

            // var_dump($this->form->isValid());
            // die();

            // if ($this->form->isValid()) {

                $this->ticketStateManager->saveTicketState($ticketState);

                return true;
            // }
        }

        return false;
    }
}
