<?php

/**
 * UserFormType class file
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
 * UserFormType class
 *
 * @category FormType
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class UserFormType extends AbstractType
{
    /**
     * Function which defines the UserForm inputs
     *
     * @param FormBuilderInterface $builder Form builder
     * @param array                $options Form ptions
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'text');
        $builder->add('password', 'password', array('required' => false));
        $builder->add('firstName', 'text', array('required' => false));
        $builder->add('lastName', 'text', array('required' => false));
        $builder->add(
            'company', 'entity', array(
                'class' => 'WebaccessBugtrackerBundle:Company',
                'property' => 'name'
            )
        );
        $builder->add('email', 'text');
    }

    /**
     * Function which set the UserForm default options
     *
     * @param OptionsResolverInterface $resolver OptionsResolverInterface
     *
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Webaccess\BugtrackerBundle\Entity\User'
            )
        );
    }

    /**
     * Function which returns the UserForm alias
     *
     * @return string
     */
    public function getName()
    {
        return 'webaccess_bugtracker_user';
    }
}
