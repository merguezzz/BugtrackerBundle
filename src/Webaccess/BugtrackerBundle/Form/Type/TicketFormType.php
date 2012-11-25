<?php

namespace Webaccess\BugtrackerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Webaccess\BugtrackerBundle\Form\Type\TicketStateFormType;
use Webaccess\BugtrackerBundle\Utility\Debug;

class TicketFormType extends AbstractType {

    protected $userManager;

    public function __construct($userManager) {
        $this->userManager = $userManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $userManager = $this->userManager;

        $builder->add('title', 'text');
		$builder->add('project', 'entity', array(
			'class' => 'WebaccessBugtrackerBundle:Project',
            'property' => 'name',
            'query_builder' => function($er) use ($userManager) {
                $qb = $er->createQueryBuilder('project')
                ->orderBy('project.name', 'ASC');
                if(!$userManager->isAdmin()) {
                    $qb->andWhere('project.company = :company_id')
                    ->setParameter('company_id', $userManager->getUserInSession()->getCompany()->getId());
                }
                return $qb;
            },
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
