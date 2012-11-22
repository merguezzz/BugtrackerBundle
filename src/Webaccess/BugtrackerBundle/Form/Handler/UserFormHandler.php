<?php

namespace Webaccess\BugtrackerBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Webaccess\BugtrackerBundle\Library\UserManager;

class UserFormHandler {

    protected $form;
	protected $request;
    protected $userManager;

    public function __construct(FormInterface $form, Request $request, UserManager $userManager) {
        $this->form = $form;
        $this->request = $request;
        $this->userManager = $userManager;
    }

	public function process($user) {
		$this->form->setData($user);

        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);

            if ($this->form->isValid()) {
                $this->userManager->saveUser($user);
                return true;
            }
        }

        return false;
	}
}
