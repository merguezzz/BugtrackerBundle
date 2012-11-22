<?php

namespace Webaccess\BugtrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CompanyController extends Controller
{
	public function indexAction($page_number) {
		$aParams['companies'] = $this->container->get('webaccess_bugtracker.company_manager')->getCompanysPaginatedList($page_number);
		$aParams['pagination'] = $this->container->get('webaccess_bugtracker.company_manager')->getCompanysPagination($page_number);
		return $this->render('WebaccessBugtrackerBundle:Company:index.html.twig', $aParams);
	}

	public function addAction() {
		$company = $this->container->get('webaccess_bugtracker.company_manager')->createCompany();
		$form = $this->container->get('webaccess_bugtracker.company.form');
		$formHandler = $this->container->get('webaccess_bugtracker.company.form_handler');

        if ($formHandler->process($company)) {
			$this->get('session')->setFlash('company_added', 1);
			return $this->redirect($this->generateUrl('webaccess_bugtracker_company'));
        }
		$aParams['form'] = $form->createView();
		return $this->render('WebaccessBugtrackerBundle:Company:add.html.twig', $aParams);
	}

	public function editAction($company_id) {
		$company = $this->container->get('webaccess_bugtracker.company_manager')->getCompany($company_id);
		$form = $this->container->get('webaccess_bugtracker.company.form');
		$formHandler = $this->container->get('webaccess_bugtracker.company.form_handler');

		if ($formHandler->process($company)) {
			$this->get('session')->setFlash('company_updated', 1);
			return $this->redirect($this->generateUrl('webaccess_bugtracker_company'));
		}
		$aParams['form'] = $form->createView();
		$aParams['company'] = $company;
		return $this->render('WebaccessBugtrackerBundle:Company:edit.html.twig', $aParams);
	}

	public function deleteAction($company_id) {
		if($this->container->get('webaccess_bugtracker.company_manager')->deleteCompany($company_id)) {
            $this->get('session')->setFlash('company_deleted', 1);
		} else {
			$this->get('session')->setFlash('company_error', 1);
		}
		return $this->redirect($this->generateUrl('webaccess_bugtracker_company'));
	}
}
