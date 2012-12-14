<?php

namespace Webaccess\BugtrackerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Webaccess\BugtrackerBundle\Form\Type\TicketStateFormType;

class TicketFormType extends AbstractType {

    protected $userManager;
    protected $translationManager;

    public function __construct($userManager, $translationManager) {
        $this->userManager = $userManager;
        $this->translationManager = $translationManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $userManager = $this->userManager;

        $builder->add('title', 'text');

		$builder->add('project', 'entity', array(
			'class' => 'WebaccessBugtrackerBundle:Project',
            'property' => 'name',
            'query_builder' => function($er) use ($userManager) {
                return $er->getByUser($userManager->getUser()->getId(), $userManager->isAdmin());
            })
        );

		$builder->add('states', 'collection', array(
            'type' => new TicketStateFormType(($userManager->getProjectInSession()) ? $userManager->getProjectInSession()->getId() : NULL, $this->translationManager))
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
	    $resolver->setDefaults(array(
	        'data_class' => 'Webaccess\BugtrackerBundle\Entity\Ticket')
        );
	}

    public function getName() {
        return 'webaccess_bugtracker_ticket';
    }
}
