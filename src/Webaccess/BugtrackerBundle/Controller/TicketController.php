<?php

/**
 * TicketController class file
 *
 * PHP 5.3
 *
 * @category Controller
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
namespace Webaccess\BugtrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * TicketController class
 *
 * @category Controller
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class TicketController extends Controller
{
    /**
     * Menu action
     *
     * @param string $route current route (for selecting menu item)
     *
     * @return Response
     */
    public function menuAction($route = '')
    {
        $aParams['route'] = $route;

        return $this->render('WebaccessBugtrackerBundle:Includes:menu.html.twig', $aParams);
    }

    /**
     * Switch language action
     *
     * @param string $lang User locale
     *
     * @return redirect
     */
    public function switchLanguageAction($lang = null)
    {
        if ($lang != null) {
            $this->get('request')->setLocale($lang);
        }

        return $this->redirect(
            $this->generateUrl(
                'webaccess_bugtracker_ticket',
                array('_locale'=> $this->get('request')->getLocale())
            )
        );
    }

    /**
     * Index action
     *
     * @param integer $pageNumber Page number
     *
     * @return Response
     */
    public function indexAction($pageNumber)
    {
        $form = $this->container->get('webaccess_bugtracker.ticket_filter.form');
        $formHandler = $this->container->get('webaccess_bugtracker.ticket_filter.form_handler');

        if ($formHandler->process()) {
            return $this->redirect($this->generateUrl('webaccess_bugtracker_ticket'));
        }

        $aParams['tickets'] = $this->container->get('webaccess_bugtracker.ticket_manager')->getTicketsPaginatedList($pageNumber);
        $aParams['pagination'] = $this->container->get('webaccess_bugtracker.ticket_manager')->getTicketsPagination($pageNumber);
        $aParams['form'] = $form->createView();

        return $this->render('WebaccessBugtrackerBundle:Ticket:index.html.twig', $aParams);
    }

    /**
     * Add ticket action
     *
     * @return Response
     */
    public function addAction()
    {
        $ticket = $this->container->get('webaccess_bugtracker.ticket_manager')->createTicket();
        $form = $this->container->get('webaccess_bugtracker.ticket.form');
        $formHandler = $this->container->get('webaccess_bugtracker.ticket.form_handler');

        // Make current user the ticket author
        $ticket->getCurrentState()->setAuthorUser($this->get('security.context')->getToken()->getUser());

        if ($formHandler->process($ticket)) {
            $this->get('session')->getFlashBag()->set('ticket_added', 1);
            $this->get('session')->getFlashBag()->set('last_ticket', $ticket->getId());

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

    /**
     * Edit ticket action
     *
     * @param integer $ticketId Ticket ID
     *
     * @return Response
     */
    public function editAction($ticketId)
    {
        $ticket = $this->container->get('webaccess_bugtracker.ticket_manager')->getTicket($ticketId);
        $form = $this->container->get('webaccess_bugtracker.ticket.form');
        $formHandler = $this->container->get('webaccess_bugtracker.ticket.form_handler');

        if ($formHandler->process($ticket)) {
            $this->get('session')->getFlashBag()->set('ticket_updated', 1);
            $this->get('session')->getFlashBag()->set('last_ticket', $ticket->getId());

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

    /**
     * Delete ticket action
     *
     * @param integer $ticketId Ticket ID
     *
     * @return Response
     */
    public function deleteAction($ticketId)
    {
        if ($this->container->get('webaccess_bugtracker.ticket_manager')->deleteTicket($ticketId)) {
            $this->get('session')->getFlashBag()->set('ticket_deleted', 1);
        } else {
            $this->get('session')->getFlashBag()->set('ticket_error', 1);
        }

        return $this->redirect($this->generateUrl('webaccess_bugtracker_ticket'));
    }

    /**
     * Test mail action
     *
     * @return Response
     */
    public function testMailAction()
    {
        $message = \Swift_Message::newInstance();

        $aParams['image_logo'] = '/bundles/webaccessbugtracker/images/logo.png';

        return $this->render('WebaccessBugtrackerBundle:Mail:ticket_edit.html.twig', $aParams);
    }
}
