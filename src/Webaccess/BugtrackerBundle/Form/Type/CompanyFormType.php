<?php

namespace Webaccess\BugtrackerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanyFormType extends AbstractType {

    protected $translationManager;

    public function __construct($translationManager) {
        $this->translationManager = $translationManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
    	$builder->add('name', 'text', array(
            'label' => $this->translationManager->trans('company.name'))
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
	    $resolver->setDefaults(array(
	        'data_class' => 'Webaccess\BugtrackerBundle\Entity\Company')
        );
	}

    public function getName() {
        return 'webaccess_bugtracker_company';
    }
}
