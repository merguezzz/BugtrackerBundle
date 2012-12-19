<?php

/**
 * ProjectManager class file
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
use Webaccess\BugtrackerBundle\Entity\Project;

/**
 * ProjectManager class file
 *
 * @category Library
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class ProjectManager
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
        $this->repository = $this->em->getRepository('WebaccessBugtrackerBundle:Project');
    }

    /**
     * Function which returns projects paginated list
     *
     * @param integer $pageNumber Page number
     *
     * @return Repository
     */
    public function getProjectsPaginatedList($pageNumber)
    {
        $pagination = $this->getProjectsPagination($pageNumber);

        return $this->repository->findBy(array(), array(), $pagination->itemsPerPageNumber, $pagination->itemsOffset);
    }

    /**
     * Function which returns projects Pagination
     *
     * @param integer $pageNumber Page number
     *
     * @return Pagination
     */
    public function getProjectsPagination($pageNumber)
    {
        return Pagination::getPagination($pageNumber, $this->repository->getTotalNumber(), 10);
    }

    /**
     * Function which creates a project
     *
     * @return Project
     */
    public function createProject()
    {
        return new Project();
    }

    /**
     * Function which saves a project in DB
     *
     * @param Project $project Project
     *
     * @return void
     */
    public function saveProject($project)
    {
        $this->em->persist($project);
        $this->em->flush();
    }

    /**
     * Function which returns a project from DB
     *
     * @param integer $projectId Project ID
     *
     * @return Project
     */
    public function getProject($projectId)
    {
        $project = $this->repository->find($projectId);

        return ($project) ? $project : false;
    }

    /**
     * Function which deletes a project in DB
     *
     * @param integer $projectId Project ID
     *
     * @return boolean
     */
    public function deleteProject($projectId)
    {
        $project = $this->getProject($projectId);
        try {
            $this->em->remove($project);
            $this->em->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
