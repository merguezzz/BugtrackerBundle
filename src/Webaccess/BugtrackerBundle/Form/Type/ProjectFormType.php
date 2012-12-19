<?php

/**
 * ProjectFormType class file
 *
 * PHP 5.3
 *
 * @category FormType
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
namespace Webaccess\BugtrackerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * ProjectFormType class
 *
 * @category FormType
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class ProjectFormType extends AbstractType
{
    /**
     * Function which defines the ProjectForm inputs
     *
     * @param FormBuilderInterface $builder Form builder
     * @param array                $options Form ptions
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add(
            'company', 'entity', array(
                'class' => 'WebaccessBugtrackerBundle:Company',
                'property' => 'name'
            )
        );
    }

    /**
     * Function which set the ProjectForm default options
     *
     * @param OptionsResolverInterface $resolver OptionsResolverInterface
     *
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Webaccess\BugtrackerBundle\Entity\Project'
            )
        );
    }

    /**
     * Function which returns the ProjectForm alias
     *
     * @return string
     */
    public function getName()
    {
        return 'webaccess_bugtracker_project';
    }
}
