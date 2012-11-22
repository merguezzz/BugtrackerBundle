<?php

namespace Webaccess\BugtrackerBundle\Library;

use Webaccess\BugtrackerBundle\Utility\Pagination;
use Webaccess\BugtrackerBundle\Entity\Project;

class ProjectManager {

    protected $em;
    protected $repository;

    /**
     * Constructor
     *
     * @param Entity manager $em
     */
	public function __construct($em) {
        $this->em = $em;
        $this->repository = $this->em->getRepository('WebaccessBugtrackerBundle:Project');
	}

    public function getProjectsPaginatedList($page_number) {
        $pagination = $this->getProjectsPagination($page_number);
        return $this->repository->findBy(array(), array(), $pagination->items_per_page_number, $pagination->items_offset);
    }

    public function getProjectsPagination($page_number) {
        return Pagination::getPagination($page_number, $this->repository->getTotalNumber(), 10);
    }

    public function createProject() {
        return new Project();
    }

    public function saveProject($project) {
        $this->em->persist($project);
        $this->em->flush();
    }

    public function getProject($project_id) {
        $project = $this->repository->find($project_id);
        return ($project) ? $project : false;
    }

    public function deleteProject($project_id) {
        $project = $this->getProject($project_id);
        try {
            $this->em->remove($project);
            $this->em->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
