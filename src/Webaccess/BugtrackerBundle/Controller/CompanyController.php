<?php

namespace Webaccess\BugtrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Webaccess\BugtrackerBundle\Entity\Company;
use Webaccess\BugtrackerBundle\Utility\Pagination;

class CompanyController extends Controller
{
	public function indexAction($page_number) {
		$em = $this->getDoctrine()->getEntityManager();
		$repositoryC = $em->getRepository('WebaccessBugtrackerBundle:Company');

		$pagination = Pagination::getPagination($page_number, $repositoryC->getTotalNumber(), 10);

        $aParams['companies'] = $repositoryC->findBy(array(), array(), $pagination->items_per_page_number, $pagination->items_offset);
		$aParams['pagination'] = $pagination;
		return $this->render('WebaccessBugtrackerBundle:Company:index.html.twig', $aParams);
	}

	public function addAction() {
		$em = $this->getDoctrine()->getEntityManager();
		$company = new Company();

		$form = $this->createFormBuilder($company)
			->add('name', 'text')
			->getForm();

		$request = $this->get('request');
		if($request->getMethod() == 'POST') {
			$form->bindRequest($request);
			
			if($form->isValid()) {
				$em->persist($company);
				$em->flush();
				$this->get('session')->setFlash('company_added', 1);

				return $this->redirect($this->generateUrl('webaccess_bugtracker_company'));
			}
		}

		$aParams['form'] = $form->createView();
		return $this->render('WebaccessBugtrackerBundle:Company:add.html.twig', $aParams);
	}

	public function editAction($company_id) {
		$em = $this->getDoctrine()->getEntityManager();
		$repositoryC = $em->getRepository('WebaccessBugtrackerBundle:Company');
		$company = $repositoryC->find($company_id);

		$form = $this->createFormBuilder($company)
			->add('name', 'text')
			->getForm();

		$request = $this->get('request');
		if($request->getMethod() == 'POST') {
			$form->bindRequest($request);
			
			if($form->isValid()) {
				$em->persist($company);
				$em->flush();
				$this->get('session')->setFlash('company_updated', 1);

				return $this->redirect($this->generateUrl('webaccess_bugtracker_company'));
			}
		}

		$aParams['form'] = $form->createView();
		$aParams['company'] = $company;
		return $this->render('WebaccessBugtrackerBundle:Company:edit.html.twig', $aParams);
	}

	public function deleteAction($company_id) {
		$em = $this->getDoctrine()->getEntityManager();
		$repositoryC = $em->getRepository('WebaccessBugtrackerBundle:Company');
		$company = $repositoryC->find($company_id);

		try {
			$em->remove($company);
			$em->flush();
			$this->get('session')->setFlash('company_deleted', 1);
		} catch (\Exception $e) {
			$this->get('session')->setFlash('company_error', 1);
		}

		return $this->redirect($this->generateUrl('webaccess_bugtracker_company'));
	}
}