<?php

namespace Webaccess\BugtrackerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanyFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
    	$builder->add('name', 'text');
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
