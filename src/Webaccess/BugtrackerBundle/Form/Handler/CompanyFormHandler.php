<?php

/**
 * CompanyFormHandler class file
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
use Webaccess\BugtrackerBundle\Library\CompanyManager;

/**
 * CompanyFormHandler class
 *
 * @category FormHandler
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class CompanyFormHandler
{
    protected $form;
    protected $request;
    protected $companyManager;

    /**
     * Constructor
     *
     * @param FormInterface  $form           FormInterface
     * @param Request        $request        Request
     * @param CompanyManager $companyManager Company Manager
     *
     * @return void
     */
    public function __construct(FormInterface $form, Request $request, CompanyManager $companyManager)
    {
        $this->form = $form;
        $this->request = $request;
        $this->companyManager = $companyManager;
    }

    /**
     * Function that handle the Company form submission
     *
     * @param Company $company Company to be processed
     *
     * @return boolean
     */
    public function process($company)
    {
        $this->form->setData($company);

        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);

            if ($this->form->isValid()) {
                $this->companyManager->saveCompany($company);

                return true;
            }
        }

        return false;
    }
}
