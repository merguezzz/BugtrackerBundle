<?php

namespace Webaccess\BugtrackerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TicketStateFormType extends AbstractType {

    const TICKET_STATE_TYPE_0 = 'Bug';
    const TICKET_STATE_TYPE_1 = 'Evolution';
    const TICKET_STATE_TYPE_2 = 'Correction orthographique';
    const TICKET_STATE_TYPE_3 = 'Question';

    const TICKET_STATE_STATUS_0 = 'A prévoir';
    const TICKET_STATE_STATUS_1 = 'A faire';
    const TICKET_STATE_STATUS_2 = 'En cours';
    const TICKET_STATE_STATUS_3 = 'A valider';
    const TICKET_STATE_STATUS_4 = 'A livrer';
    const TICKET_STATE_STATUS_5 = 'Livré';
    const TICKET_STATE_STATUS_6 = 'Archivé';

    const TICKET_STATE_PRIORITY_0 = 'Basse';
    const TICKET_STATE_PRIORITY_1 = 'Moyenne';
    const TICKET_STATE_PRIORITY_2 = 'Haute';

    public function getTicketStatesTypes() {
        return array(
            0 => self::TICKET_STATE_TYPE_0,
            1 => self::TICKET_STATE_TYPE_1,
            2 => self::TICKET_STATE_TYPE_2,
        );
    }

    public function getTicketStatesStatus() {
        return array(
            0 => self::TICKET_STATE_STATUS_0,
            1 => self::TICKET_STATE_STATUS_1,
            2 => self::TICKET_STATE_STATUS_2,
            3 => self::TICKET_STATE_STATUS_3,
            4 => self::TICKET_STATE_STATUS_4,
            5 => self::TICKET_STATE_STATUS_5,
            6 => self::TICKET_STATE_STATUS_6,
        );
    }

    public function getTicketStatesPriorities() {
        return array(
            0 => self::TICKET_STATE_PRIORITY_0,
            1 => self::TICKET_STATE_PRIORITY_1,
            2 => self::TICKET_STATE_PRIORITY_2,
        );
    }

    public function __construct($project_id) {
        $this->project_id = $project_id;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $project_id = $this->project_id;

        $builder->add('content', 'textarea', array('required' => false));
		$builder->add('authorUser', 'entity', array(
			'class' => 'WebaccessBugtrackerBundle:User',
			'property' => 'username')
        );
        $builder->add('allocatedUser', 'entity', array(
            'class' => 'WebaccessBugtrackerBundle:User',
            'property' => 'username',
            'query_builder' => function($er) use ($project_id) {
                return $er->findByProject($project_id);
           })
        );
        $builder->add('type', 'choice', array(
            'choices' => $this->getTicketStatesTypes())
        );
        $builder->add('status', 'choice', array(
            'choices' => $this->getTicketStatesStatus())
        );
        $builder->add('priority', 'choice', array(
            'choices' => $this->getTicketStatesPriorities())
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
