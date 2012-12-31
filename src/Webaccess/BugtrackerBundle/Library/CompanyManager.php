<?php

/**
 * CompanyManager class file
 *
 * PHP 5.3
 *
 * @category Library
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
namespace Webaccess\BugtrackerBundle\Library;

use Webaccess\BugtrackerBundle\Utility\Pagination;
use Webaccess\BugtrackerBundle\Entity\Company;

/**
 * CompanyManager class
 *
 * @category Library
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class CompanyManager
{
    protected $em;
    protected $repository;

    /**
     * Constructor
     *
     * @param EntityManager $em EntityManager
     *
     * @return void
     */
    public function __construct($em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('WebaccessBugtrackerBundle:Company');
    }

    /**
     * Function which returns companies paginated list
     *
     * @param integer $pageNumber Page number
     *
     * @return Repository
     */
    public function getCompaniesPaginatedList($pageNumber)
    {
        $pagination = $this->getCompaniesPagination($pageNumber);

        return $this->repository->findBy(array(), array(), $pagination->itemsPerPageNumber, $pagination->itemsOffset);
    }

    /**
     * Function which returns companies Pagination
     *
     * @param integer $pageNumber Page number
     *
     * @return Pagination
     */
    public function getCompaniesPagination($pageNumber)
    {
        return Pagination::getPagination($pageNumber, $this->repository->getTotalNumber(), 10);
    }

    /**
     * Function which creates a company
     *
     * @return Company
     */
    public function createCompany()
    {
        return new Company();
    }

    /**
     * Function which saves a company in DB
     *
     * @param Company $company Company
     *
     * @return void
     */
    public function saveCompany($company)
    {
        $this->em->persist($company);
        $this->em->flush();
    }

    /**
     * Function which returns a company from DB
     *
     * @param integer $companyId Company ID
     *
     * @return Company
     */
    public function getCompany($companyId)
    {
        $company = $this->repository->find($companyId);

        return ($company) ? $company : false;
    }

    /**
     * Function which deletes a company from DB
     *
     * @param integer $companyId Company ID
     *
     * @return boolean
     */
    public function deleteCompany($companyId)
    {
        $company = $this->getCompany($companyId);
        try {
            $this->em->remove($company);
            $this->em->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
