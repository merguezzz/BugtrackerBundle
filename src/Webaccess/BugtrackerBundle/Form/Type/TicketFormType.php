<?php

/**
 * TicketFormType class file
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
use Webaccess\BugtrackerBundle\Form\Type\TicketStateFormType;

/**
 * TicketFormType class
 *
 * @category FormType
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class TicketFormType extends AbstractType
{
    protected $userManager;
    protected $translationManager;

    /**
     * Constructor
     *
     * @param UserManager        $userManager        UserManager
     * @param TranslationManager $translationManager TranslationManager
     *
     * @return void
     */
    public function __construct($userManager, $translationManager)
    {
        $this->userManager = $userManager;
        $this->translationManager = $translationManager;
    }

    /**
     * Function which defines the TicketForm inputs
     *
     * @param FormBuilderInterface $builder Form builder
     * @param array                $options Form ptions
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $translationManager = $this->translationManager;
        $userManager = $this->userManager;

        $builder->add('title', 'text');

        $builder->add(
            'project', 'entity', array(
                'class' => 'WebaccessBugtrackerBundle:Project',
                'property' => 'name',
                'query_builder' => function ($er) use ($userManager) {
                    return $er->getByUser($userManager->getUser()->getId(), $userManager->isAdmin());
                }
            )
        );

        $builder->add(
            'states', 'collection', array(
                'type' => new TicketStateFormType(
                    ($userManager->getProjectInSession()) ? $userManager->getProjectInSession()->getId() : null, $translationManager, $userManager
                )
            )
        );
    }

    /**
     * Function which set the TicketForm default options
     *
     * @param OptionsResolverInterface $resolver OptionsResolverInterface
     *
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Webaccess\BugtrackerBundle\Entity\Ticket'
            )
        );
    }

    /**
     * Function which returns the TicketForm alias
     *
     * @return string
     */
    public function getName()
    {
        return 'webaccess_bugtracker_ticket';
    }
}
