<?php

namespace Webaccess\BugtrackerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectFormType extends AbstractType {

	protected $translationManager;

    public function __construct($translationManager) {
        $this->translationManager = $translationManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', 'text', array(
        	'label' => $this->translationManager->trans('project.name'))
        );
		$builder->add('company', 'entity', array(
			'class' => 'WebaccessBugtrackerBundle:Company',
			'property' => 'name',
        	'label' => $this->translationManager->trans('project.company'))
		);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
	    $resolver->setDefaults(array(
	        'data_class' => 'Webaccess\BugtrackerBundle\Entity\Project')
	    );
	}

    public function getName() {
        return 'webaccess_bugtracker_project';
    }
}
