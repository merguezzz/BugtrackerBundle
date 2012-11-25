<?php

namespace Webaccess\BugtrackerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Webaccess\BugtrackerBundle\Form\Type\TicketStateFormType;

class TicketFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', 'text');
		$builder->add('project', 'entity', array(
			'class' => 'WebaccessBugtrackerBundle:Project',
			'property' => 'name'));
		$builder->add('states', 'collection', array(
            'type' => new TicketStateFormType()));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
	    $resolver->setDefaults(array(
	        'data_class' => 'Webaccess\BugtrackerBundle\Entity\Ticket',
	    ));
	}

    public function getName() {
        return 'webaccess_bugtracker_ticket';
    }
}
