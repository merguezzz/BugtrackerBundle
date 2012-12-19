<?php

/**
 * ProjectController class file
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
 * ProjectController class
 *
 * @category Controller
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class ProjectController extends Controller
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
        $aParams['projects'] = $this->container->get('webaccess_bugtracker.project_manager')->getProjectsPaginatedList($pageNumber);
        $aParams['pagination'] = $this->container->get('webaccess_bugtracker.project_manager')->getProjectsPagination($pageNumber);

        return $this->render('WebaccessBugtrackerBundle:Project:index.html.twig', $aParams);
    }

    /**
     * Add project action
     *
     * @return Response
     */
    public function addAction()
    {
        $project = $this->container->get('webaccess_bugtracker.project_manager')->createProject();
        $form = $this->container->get('webaccess_bugtracker.project.form');
        $formHandler = $this->container->get('webaccess_bugtracker.project.form_handler');

        if ($formHandler->process($project)) {
            $this->get('session')->setFlash('project_added', 1);
            return $this->redirect($this->generateUrl('webaccess_bugtracker_project'));
        }

        $aParams['form'] = $form->createView();

        return $this->render('WebaccessBugtrackerBundle:Project:add.html.twig', $aParams);
    }

    /**
     * Edit project action
     *
     * @param integer $projectId Project ID
     *
     * @return Response
     */
    public function editAction($projectId)
    {
        $project = $this->container->get('webaccess_bugtracker.project_manager')->getProject($projectId);
        $form = $this->container->get('webaccess_bugtracker.project.form');
        $formHandler = $this->container->get('webaccess_bugtracker.project.form_handler');

        if ($formHandler->process($project)) {
            $this->get('session')->setFlash('project_updated', 1);
            return $this->redirect($this->generateUrl('webaccess_bugtracker_project'));
        }

        $aParams['form'] = $form->createView();
        $aParams['project'] = $project;

        return $this->render('WebaccessBugtrackerBundle:Project:edit.html.twig', $aParams);
    }

    /**
     * Delete project action
     *
     * @param integer $projectId Project ID
     *
     * @return Response
     */
    public function deleteAction($projectId)
    {
        if ($this->container->get('webaccess_bugtracker.project_manager')->deleteProject($projectId)) {
            $this->get('session')->setFlash('project_deleted', 1);
        } else {
            $this->get('session')->setFlash('project_error', 1);
        }

        return $this->redirect($this->generateUrl('webaccess_bugtracker_project'));
    }
}
