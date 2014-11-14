<?php

/**
 * UserController class file
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

/**
 * UserController class
 *
 * @category Controller
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class UserController extends Controller
{
    /**
     * Index action
     *
     * @param integer $pageNumber Page number
     *
     * @return Response
     */
    public function indexAction($pageNumber)
    {
        $aParams['users'] = $this->container->get('webaccess_bugtracker.user_manager')->getUsersPaginatedList($pageNumber);
        $aParams['pagination'] = $this->container->get('webaccess_bugtracker.user_manager')->getUsersPagination($pageNumber);

        return $this->render('WebaccessBugtrackerBundle:User:index.html.twig', $aParams);
    }

    /**
     * Add user action
     *
     * @return Response
     */
    public function addAction()
    {
        $user = $this->container->get('webaccess_bugtracker.user_manager')->createUser();
        $form = $this->container->get('webaccess_bugtracker.user.form');
        $formHandler = $this->container->get('webaccess_bugtracker.user.form_handler');

        if ($formHandler->process($user)) {
            $this->get('session')->getFlashBag()->set('user_added', 1);
            return $this->redirect($this->generateUrl('webaccess_bugtracker_user'));
        }

        $aParams['form'] = $form->createView();

        return $this->render('WebaccessBugtrackerBundle:User:add.html.twig', $aParams);
    }

    /**
     * Edit user action
     *
     * @param integer $userId User ID
     *
     * @return Response
     */
    public function editAction($userId)
    {
        $user = $this->container->get('webaccess_bugtracker.user_manager')->getUserById($userId);
        $form = $this->container->get('webaccess_bugtracker.user.form');
        $formHandler = $this->container->get('webaccess_bugtracker.user.form_handler');

        if ($formHandler->process($user)) {
            $this->get('session')->getFlashBag()->set('user_updated', 1);
            return $this->redirect($this->generateUrl('webaccess_bugtracker_user'));
        }

        $aParams['form'] = $form->createView();
        $aParams['user'] = $user;

        return $this->render('WebaccessBugtrackerBundle:User:edit.html.twig', $aParams);
    }

    /**
     * Delete user action
     *
     * @param integer $userId User ID
     *
     * @return Response
     */
    public function deleteAction($userId)
    {
        if ($this->container->get('webaccess_bugtracker.user_manager')->deleteUser($userId)) {
            $this->get('session')->getFlashBag()->set('user_deleted', 1);
        } else {
            $this->get('session')->getFlashBag()->set('user_error', 1);
        }

        return $this->redirect($this->generateUrl('webaccess_bugtracker_user'));
    }
}
