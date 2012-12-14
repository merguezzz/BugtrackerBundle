<?php

namespace Webaccess\BugtrackerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TicketFilterFormType extends AbstractType {

    protected $userManager;
	protected $translationManager;

    public function __construct($userManager, $translationManager) {
        $this->userManager = $userManager;
        $this->translationManager = $translationManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $userManager = $this->userManager;

		$builder->add('project', 'entity', array(
			'class' => 'WebaccessBugtrackerBundle:Project',
			'empty_value' => $this->translationManager->trans('menu.all_projects'),
			'data' => $userManager->getProjectInSession(),
            'property' => 'name',
            'required' => false,
            'query_builder' => function($er) use ($userManager) {
                return $er->getByUser($userManager->getUser()->getId(), $userManager->isAdmin());
            })
        );

        $builder->add('user', 'entity', array(
            'class' => 'WebaccessBugtrackerBundle:User',
            'empty_value' => $this->translationManager->trans('menu.all_users'),
            'data' => $userManager->getUserInSession(),
            'property' => 'completename',
            'required' => false,
            'query_builder' => function($er) use ($userManager) {
                return $er->getByCompany($userManager->getUser()->getCompany()->getId(), $userManager->isAdmin());
            })
        );

        $builder->add('type', 'choice', array(
            'choices' => array(
                1 => $this->translationManager->trans('ticket_state.type.1'),
                2 => $this->translationManager->trans('ticket_state.type.2'),
                3 => $this->translationManager->trans('ticket_state.type.3'),
                4 => $this->translationManager->trans('ticket_state.type.4')),
            'empty_value' => $this->translationManager->trans('menu.all_types'),
            'data' => $userManager->getTypeInSession(),
            'required' => false)
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
                8 => $this->translationManager->trans('ticket_state.status.8')),
            'empty_value' => $this->translationManager->trans('menu.all_statuses'),
            'data' => $userManager->getStatusInSession(),
            'required' => false)
        );

        $builder->add('priority', 'choice', array(
            'choices' => array(
                1 => $this->translationManager->trans('ticket_state.priority.1'),
                2 => $this->translationManager->trans('ticket_state.priority.2'),
                3 => $this->translationManager->trans('ticket_state.priority.3')),
            'empty_value' => $this->translationManager->trans('menu.all_priorities'),
            'data' => $userManager->getPriorityInSession(),
            'required' => false)
        );
    }

    public function getName() {
        return 'webaccess_bugtracker_ticket_filter';
    }
}
