<?php

namespace Webaccess\BugtrackerBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Webaccess\BugtrackerBundle\Library\CompanyManager;

class CompanyFormHandler {

    protected $form;
	protected $request;
    protected $companyManager;

    public function __construct(FormInterface $form, Request $request, CompanyManager $companyManager) {
        $this->form = $form;
        $this->request = $request;
        $this->companyManager = $companyManager;
    }

	public function process($company) {
		$this->form->setData($company);

        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);

            if ($this->form->isValid()) {
                $this->companyManager->saveCompany($company);
                return true;
            }
        }

        return false;
	}
}
