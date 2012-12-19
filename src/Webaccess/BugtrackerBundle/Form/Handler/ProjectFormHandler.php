<?php

/**
 * ProjectFormHandler class file
 *
 * PHP 5.3
 *
 * @category FormHandler
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
namespace Webaccess\BugtrackerBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Webaccess\BugtrackerBundle\Library\ProjectManager;

/**
 * ProjectFormHandler class
 *
 * @category FormHandler
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class ProjectFormHandler
{
    protected $form;
    protected $request;
    protected $projectManager;

    /**
     * Constructor
     *
     * @param FormInterface  $form           FormInterface
     * @param Request        $request        Request
     * @param ProjectManager $projectManager Project Manager
     *
     * @return void
     */
    public function __construct(FormInterface $form, Request $request, ProjectManager $projectManager)
    {
        $this->form = $form;
        $this->request = $request;
        $this->projectManager = $projectManager;
    }

    /**
     * Function that handle the Project form submission
     *
     * @param Project $project Project to be processed
     *
     * @return boolean
     */
    public function process($project)
    {
        $this->form->setData($project);

        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);

            if ($this->form->isValid()) {
                $this->projectManager->saveProject($project);

                return true;
            }
        }

        return false;
    }
}
