<?php

namespace Webaccess\BugtrackerBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class SwitchProjectFormHandler {

    protected $form;
	protected $request;

    public function __construct(FormInterface $form, Request $request) {
        $this->form = $form;
        $this->request = $request;
    }

	public function process() {

        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);

            if ($this->form->isValid()) {
                $aProject = $this->request->request->get('webaccess_bugtracker_switch_project');
                return $aProject['project'];
            }
        }

        return false;
	}
}
