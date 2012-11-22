<?php

namespace Webaccess\BugtrackerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('username', 'text');
		$builder->add('password', 'password', array('required' => false));
		$builder->add('firstName', 'text', array('required' => false));
		$builder->add('lastName', 'text', array('required' => false));
		$builder->add('email', 'text');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
	    $resolver->setDefaults(array(
	        'data_class' => 'Webaccess\BugtrackerBundle\Entity\User',
	    ));
	}

    public function getName() {
        return 'webaccess_bugtracker_user';
    }
}
