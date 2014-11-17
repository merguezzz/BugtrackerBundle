<?php

/**
 * TicketFilterFormType class file
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
 * TicketFilterFormType class
 *
 * @category FormType
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class TicketFilterFormType extends AbstractType
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
     * Function which defines the TicketFilterForm inputs
     *
     * @param FormBuilderInterface $builder Form builder
     * @param array                $options Form ptions
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $userManager = $this->userManager;

        $builder->add(
            'project', 'entity', array(
                'class' => 'WebaccessBugtrackerBundle:Project',
                'empty_value' => $this->translationManager->trans('menu.all_projects'),
                'data' => $userManager->getProjectInSession(),
                'property' => 'name',
                'required' => false,
                'query_builder' => function ($er) use ($userManager) {
                    return $er->getByUser(
                        $userManager->getUser()->getId(), $userManager->isAdmin()
                    );
                }
            )
        );

        $builder->add(
            'user', 'entity', array(
                'class' => 'WebaccessBugtrackerBundle:User',
                'empty_value' => $this->translationManager->trans('menu.all_users'),
                'data' => $userManager->getUserInSession(),
                'property' => 'completename',
                'required' => false,
                'query_builder' => function ($er) use ($userManager) {
                    return $er->findByProject(null, $userManager->getUser()->getId(), $userManager->isAdmin());
                }
            )
        );

        $builder->add(
            'type', 'choice', array(
                'choices' => array(
                    1 => $this->translationManager->trans('ticket_state.type.1'),
                    2 => $this->translationManager->trans('ticket_state.type.2'),
                    3 => $this->translationManager->trans('ticket_state.type.3'),
                    4 => $this->translationManager->trans('ticket_state.type.4')
                ),
                'empty_value' => $this->translationManager->trans('menu.all_types'),
                'data' => $userManager->getTypeInSession(),
                'required' => false
            )
        );

        $builder->add(
            'status', 'choice', array(
                'choices' => array(
                    1 => $this->translationManager->trans('ticket_state.status.1'),
                    2 => $this->translationManager->trans('ticket_state.status.2'),
                    3 => $this->translationManager->trans('ticket_state.status.3'),
                    4 => $this->translationManager->trans('ticket_state.status.4'),
                    5 => $this->translationManager->trans('ticket_state.status.5'),
                    6 => $this->translationManager->trans('ticket_state.status.6'),
                    7 => $this->translationManager->trans('ticket_state.status.7'),
                    8 => $this->translationManager->trans('ticket_state.status.8')
                ),
                'empty_value' => $this->translationManager->trans('menu.all_statuses'),
                'data' => $userManager->getStatusInSession(),
                'required' => false
            )
        );

        $builder->add(
            'priority', 'choice', array(
                'choices' => array(
                    1 => $this->translationManager->trans('ticket_state.priority.1'),
                    2 => $this->translationManager->trans('ticket_state.priority.2'),
                    3 => $this->translationManager->trans('ticket_state.priority.3')
                ),
                'empty_value' => $this->translationManager->trans('menu.all_priorities'),
                'data' => $userManager->getPriorityInSession(),
                'required' => false
            )
        );

        $builder->add(
            'closed', 'choice', array(
                'choices' => array(
                    0 => $this->translationManager->trans('ticket_state.closed.0'),
                    1 => $this->translationManager->trans('ticket_state.closed.1'),
                ),
                'empty_value' => false,
                'data' => $userManager->getClosedInSession(),
                'required' => false
            )
        );
    }

    /**
     * Function which returns the TicketFilterForm alias
     *
     * @return string
     */
    public function getName()
    {
        return 'webaccess_bugtracker_ticket_filter';
    }
}
