<?php

namespace Webaccess\BugtrackerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TicketStateFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('content', 'textarea', array('required' => false));
		$builder->add('authorUser', 'entity', array(
			'class' => 'WebaccessBugtrackerBundle:User',
			'property' => 'username'));
        $builder->add('allocatedUser', 'entity', array(
            'class' => 'WebaccessBugtrackerBundle:User',
            'property' => 'username'));
        $builder->add('type', 'choice', array(
            'choices' => array(0 => 'Bug', 1 => 'Evolution', 2 => 'Question')
        ));
        $builder->add('status', 'integer');
        $builder->add('priority', 'integer');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
	    $resolver->setDefaults(array(
	        'data_class' => 'Webaccess\BugtrackerBundle\Entity\TicketState',
	    ));
	}

    public function getName() {
        return 'webaccess_bugtracker_ticket_state';
    }
}
