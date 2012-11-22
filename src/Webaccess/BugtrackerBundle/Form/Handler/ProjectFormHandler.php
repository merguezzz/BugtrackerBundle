<?php

namespace Webaccess\BugtrackerBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Webaccess\BugtrackerBundle\Library\ProjectManager;

class ProjectFormHandler {

    protected $form;
	protected $request;
    protected $projectManager;

    public function __construct(FormInterface $form, Request $request, ProjectManager $projectManager) {
        $this->form = $form;
        $this->request = $request;
        $this->projectManager = $projectManager;
    }

	public function process($project) {
		$this->form->setData($project);

        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);

            if ($this->form->isValid()) {
                $this->projectManager->saveProject($project);
                return true;
            }
        }

        return false;
	}
}
