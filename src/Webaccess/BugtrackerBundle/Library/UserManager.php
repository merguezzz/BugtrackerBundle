<?php

/**
 * UserManager class file
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
use Webaccess\BugtrackerBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

/**
 * UserManager class
 *
 * @category Library
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class UserManager
{
    protected $em;
    protected $repository;
    protected $encoderFactory;

    /**
     * Constructor
     *
     * @param EntityManager   $em              EntityManager
     * @param EncoderFactory  $encoderFactory  EncoderFactory
     * @param SecurityContext $securityContext SecurityContext
     * @param Session         $session         Session
     *
     * @return void
     */
    public function __construct($em, EncoderFactory $encoderFactory, $securityContext, $session)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('WebaccessBugtrackerBundle:User');
        $this->repositoryProject = $this->em->getRepository('WebaccessBugtrackerBundle:Project');
        $this->encoderFactory = $encoderFactory;
        $this->securityContext = $securityContext;
        $this->session = $session;
    }

    /**
     * Function which returns users paginated list
     *
     * @param integer $pageNumber Page number
     *
     * @return Repository
     */
    public function getUsersPaginatedList($pageNumber)
    {
        $pagination = $this->getUsersPagination($pageNumber);

        return $this->repository->findBy(array(), array(), $pagination->itemsPerPageNumber, $pagination->itemsOffset);
    }

    /**
     * Function which returns users Pagination
     *
     * @param integer $pageNumber Page number
     *
     * @return Pagination
     */
    public function getUsersPagination($pageNumber)
    {
        return Pagination::getPagination($pageNumber, $this->repository->getTotalNumber(), 10);
    }

    /**
     * Function which creates a user
     *
     * @return User
     */
    public function createUser()
    {
        return new User();
    }

    /**
     * Function which saves a user in DB
     *
     * @param User $user User
     *
     * @return void
     */
    public function saveUser($user)
    {
        //Password management
        $encoder = $this->encoderFactory->getEncoder($user);
        $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
        $user->setPassword($password);

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * Function which returns a user from DB
     *
     * @param integer $userId User ID
     *
     * @return User
     */
    public function getUserById($userId)
    {
        $user = $this->repository->find($userId);

        return ($user) ? $user : null;
    }

    /**
     * Function which returns a user from Session
     *
     * @return User
     */
    public function getUser()
    {
        return ($this->securityContext->getToken()) ? $this->securityContext->getToken()->getUser() : null;
    }

    /**
     * Function which returns the user in session
     *
     * @return integer
     */
    public function getUserInSession()
    {
        $userId = $this->session->get('current_user');

        return ($userId) ? $this->getUserById($userId) : null;
    }

    /**
     * Function which returns the project in session
     *
     * @return integer
     */
    public function getProjectInSession()
    {
        $projectId = $this->session->get('current_project');

        return ($projectId) ? $this->repositoryProject->find($projectId) : null;
    }

    /**
     * Function which returns the type in session
     *
     * @return integer
     */
    public function getTypeInSession()
    {
        $typeId = $this->session->get('current_type');

        return ($typeId) ? $typeId : null;
    }

    /**
     * Function which returns the status in session
     *
     * @return integer
     */
    public function getStatusInSession()
    {
        $statusId = $this->session->get('current_status');

        return ($statusId) ? $statusId : null;
    }

    /**
     * Function which returns the priority in session
     *
     * @return integer
     */
    public function getPriorityInSession()
    {
        $priorityId = $this->session->get('current_priority');

        return ($priorityId) ? $priorityId : null;
    }

    /**
     * Function which deletes a user in DB
     *
     * @param integer $userId User ID
     *
     * @return boolean
     */
    public function deleteUser($userId)
    {
        $user = $this->getUserById($userId);
        try {
            $this->em->remove($user);
            $this->em->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Function which checks if a user is an admin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->securityContext->isGranted('ROLE_ADMIN');
    }
}
