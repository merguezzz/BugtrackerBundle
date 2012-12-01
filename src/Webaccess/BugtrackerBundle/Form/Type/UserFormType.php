<?php

namespace Webaccess\BugtrackerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserFormType extends AbstractType {

    protected $translationManager;

    public function __construct($translationManager) {
        $this->translationManager = $translationManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('username', 'text', array(
            'label' => $this->translationManager->trans('user.username'))
        );
		$builder->add('password', 'password', array('required' => false,
			'label' => $this->translationManager->trans('user.password'))
		);
		$builder->add('firstName', 'text', array('required' => false,
			'label' => $this->translationManager->trans('user.first_name'))
		);
		$builder->add('lastName', 'text', array('required' => false,
			'label' => $this->translationManager->trans('user.last_name'))
		);
		$builder->add('email', 'text', array(
			'label' => $this->translationManager->trans('user.email'))
		);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
	    $resolver->setDefaults(array(
	        'data_class' => 'Webaccess\BugtrackerBundle\Entity\User')
	    );
	}

    public function getName() {
        return 'webaccess_bugtracker_user';
    }
}
