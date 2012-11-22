<?php

namespace Webaccess\BugtrackerBundle\Library;

use Webaccess\BugtrackerBundle\Utility\Pagination;
use Webaccess\BugtrackerBundle\Entity\Company;

class CompanyManager {

    protected $em;
    protected $repository;

    /**
     * Constructor
     *
     * @param Entity manager $em
     */
	public function __construct($em) {
        $this->em = $em;
        $this->repository = $this->em->getRepository('WebaccessBugtrackerBundle:Company');
	}

    public function getCompanysPaginatedList($page_number) {
        $pagination = $this->getCompanysPagination($page_number);
        return $this->repository->findBy(array(), array(), $pagination->items_per_page_number, $pagination->items_offset);
    }

    public function getCompanysPagination($page_number) {
        return Pagination::getPagination($page_number, $this->repository->getTotalNumber(), 10);
    }

    public function createCompany() {
        return new Company();
    }

    public function saveCompany($company) {
        $this->em->persist($company);
        $this->em->flush();
    }

    public function getCompany($company_id) {
        $company = $this->repository->find($company_id);
        return ($company) ? $company : false;
    }

    public function deleteCompany($company_id) {
        $company = $this->getCompany($company_id);
        try {
            $this->em->remove($company);
            $this->em->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
