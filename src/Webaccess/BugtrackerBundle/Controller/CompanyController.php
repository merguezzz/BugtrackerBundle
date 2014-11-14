<?php

/**
 * CompanyController class file
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
 * CompanyController class
 *
 * @category Controller
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class CompanyController extends Controller
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
        $aParams['companies'] = $this->container->get('webaccess_bugtracker.company_manager')->getCompaniesPaginatedList($pageNumber);
        $aParams['pagination'] = $this->container->get('webaccess_bugtracker.company_manager')->getCompaniesPagination($pageNumber);

        return $this->render('WebaccessBugtrackerBundle:Company:index.html.twig', $aParams);
    }

    /**
     * Add company action
     *
     * @return Response
     */
    public function addAction()
    {
        $company = $this->container->get('webaccess_bugtracker.company_manager')->createCompany();
        $form = $this->container->get('webaccess_bugtracker.company.form');
        $formHandler = $this->container->get('webaccess_bugtracker.company.form_handler');

        if ($formHandler->process($company)) {
            $this->get('session')->getFlashBag()->set('company_added', 1);
            return $this->redirect($this->generateUrl('webaccess_bugtracker_company'));
        }

        $aParams['form'] = $form->createView();

        return $this->render('WebaccessBugtrackerBundle:Company:add.html.twig', $aParams);
    }

    /**
     * Edit company action
     *
     * @param integer $companyId Company ID
     *
     * @return Response
     */
    public function editAction($companyId)
    {
        $company = $this->container->get('webaccess_bugtracker.company_manager')->getCompany($companyId);
        $form = $this->container->get('webaccess_bugtracker.company.form');
        $formHandler = $this->container->get('webaccess_bugtracker.company.form_handler');

        if ($formHandler->process($company)) {
            $this->get('session')->getFlashBag()->set('company_updated', 1);
            return $this->redirect($this->generateUrl('webaccess_bugtracker_company'));
        }

        $aParams['form'] = $form->createView();
        $aParams['company'] = $company;

        return $this->render('WebaccessBugtrackerBundle:Company:edit.html.twig', $aParams);
    }

    /**
     * Delete company action
     *
     * @param integer $companyId Company ID
     *
     * @return Response
     */
    public function deleteAction($companyId)
    {
        if ($this->container->get('webaccess_bugtracker.company_manager')->deleteCompany($companyId)) {
            $this->get('session')->getFlashBag()->set('company_deleted', 1);
        } else {
            $this->get('session')->getFlashBag()->set('company_error', 1);
        }

        return $this->redirect($this->generateUrl('webaccess_bugtracker_company'));
    }
}
