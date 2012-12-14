<?php

namespace Webaccess\BugtrackerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TicketStateFormType extends AbstractType {

    public function __construct($project_id, $translationManager) {
        $this->project_id = $project_id;
        $this->translationManager = $translationManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $project_id = $this->project_id;

        $builder->add('content', 'textarea', array(
            'required' => false,
            'attr' => array('rows' => 5))
        );

		$builder->add('authorUser', 'entity', array(
			'class' => 'WebaccessBugtrackerBundle:User',
			'property' => 'completeName')
        );

        $builder->add('allocatedUser', 'entity', array(
            'class' => 'WebaccessBugtrackerBundle:User',
            'property' => 'completeName',
            'query_builder' => function($er) use ($project_id) {
                return $er->findByProject($project_id);
           })
        );

        $builder->add('type', 'choice', array(
            'choices' => array(
                1 => $this->translationManager->trans('ticket_state.type.1'),
                2 => $this->translationManager->trans('ticket_state.type.2'),
                3 => $this->translationManager->trans('ticket_state.type.3'),
                4 => $this->translationManager->trans('ticket_state.type.4')))
        );

        $builder->add('status', 'choice', array(
            'choices' => array(
                1 => $this->translationManager->trans('ticket_state.status.1'),
                2 => $this->translationManager->trans('ticket_state.status.2'),
                3 => $this->translationManager->trans('ticket_state.status.3'),
                4 => $this->translationManager->trans('ticket_state.status.4'),
                5 => $this->translationManager->trans('ticket_state.status.5'),
                6 => $this->translationManager->trans('ticket_state.status.6'),
                7 => $this->translationManager->trans('ticket_state.status.7'),
                8 => $this->translationManager->trans('ticket_state.status.8')))
        );

        $builder->add('priority', 'choice', array(
            'choices' => array(
                1 => $this->translationManager->trans('ticket_state.priority.1'),
                2 => $this->translationManager->trans('ticket_state.priority.2'),
                3 => $this->translationManager->trans('ticket_state.priority.3')))
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
	    $resolver->setDefaults(array(
	        'data_class' => 'Webaccess\BugtrackerBundle\Entity\TicketState')
        );
	}

    public function getDefaultOptions(array $options) {
        return array(
            'my_option' => false
        );
    }

    public function getName() {
        return 'webaccess_bugtracker_ticket_state';
    }
}
