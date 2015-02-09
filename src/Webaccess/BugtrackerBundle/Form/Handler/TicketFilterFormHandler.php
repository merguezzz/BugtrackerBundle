<?php

/**
 * TicketFilterFormHandler class file
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

/**
 * TicketFilterFormHandler class
 *
 * @category FormHandler
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class TicketFilterFormHandler
{
    protected $form;
    protected $request;
    protected $session;

    /**
     * Constructor
     *
     * @param FormInterface $form    FormInterface
     * @param Request       $request Request
     * @param Session       $session Session
     *
     * @return void
     */
    public function __construct(FormInterface $form, Request $request, $session)
    {
        $this->form = $form;
        $this->request = $request;
        $this->session = $session;
    }

    /**
     * Function that handle the TicketFilter form submission
     *
     * @return boolean
     */
    public function process()
    {
        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);

            if ($this->form->isValid()) {
                
                $aTicketFilter = $this->request->request->get('webaccess_bugtracker_ticket_filter');
                $this->session->set('current_project', $aTicketFilter['project']);
                $this->session->set('current_user', $aTicketFilter['user']);
                $this->session->set('current_type', $aTicketFilter['type']);
                $this->session->set('current_status', $aTicketFilter['status']);
                $this->session->set('current_priority', $aTicketFilter['priority']);
                $this->session->set('current_closed', $aTicketFilter['closed']);

                return true;
            }
        }

        return false;
    }
}
