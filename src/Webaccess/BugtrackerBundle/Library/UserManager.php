<?php

namespace Webaccess\BugtrackerBundle\Library;

use Webaccess\BugtrackerBundle\Utility\Pagination;
use Webaccess\BugtrackerBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class UserManager {

    protected $em;
    protected $repository;
    protected $encoderFactory;

    /**
     * Constructor
     *
     * @param Entity manager $em
     * @param EncoderFactory $encoderFactory
     * @param Security contect $securityContext
     */
	public function __construct($em, EncoderFactory $encoderFactory, $securityContext, $session) {
        $this->em = $em;
        $this->repository = $this->em->getRepository('WebaccessBugtrackerBundle:User');
        $this->repositoryProject = $this->em->getRepository('WebaccessBugtrackerBundle:Project');
        $this->encoderFactory = $encoderFactory;
        $this->securityContext = $securityContext;
        $this->session = $session;
	}

    public function getUsersPaginatedList($page_number) {
        $pagination = $this->getUsersPagination($page_number);
        return $this->repository->findBy(array(), array(), $pagination->items_per_page_number, $pagination->items_offset);
    }

    public function getUsersPagination($page_number) {
        return Pagination::getPagination($page_number, $this->repository->getTotalNumber(), 10);
    }

    public function createUser() {
        return new User();
    }

    public function saveUser($user) {
        //Password management
        $encoder = $this->encoderFactory->getEncoder($user);
        $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
        $user->setPassword($password);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function getUserById($user_id) {
        $user = $this->repository->find($user_id);
        return ($user) ? $user : NULL;
    }

    public function getUser() {
        if($this->securityContext->getToken()) {
            return $this->securityContext->getToken()->getUser();
        }
    }

    public function getUserInSession() {
        $user_id = $this->session->get('current_user');
        if($user_id) {
            return $this->getUserById($user_id);
        }
        return NULL;
    }

    public function getProjectInSession() {
        $project_id = $this->session->get('current_project');
        if($project_id) {
            $project = $this->repositoryProject->find($project_id);
            return ($project) ? $project : NULL;
        }
        return NULL;
    }

    public function getTypeInSession() {
        $type_id = $this->session->get('current_type');
        if($type_id) {
            return $type_id;
        }
        return NULL;
    }

    public function getStatusInSession() {
        $status_id = $this->session->get('current_status');
        if($status_id) {
            return $status_id;
        }
        return NULL;
    }

    public function getPriorityInSession() {
        $priority_id = $this->session->get('current_priority');
        if($priority_id) {
            return $priority_id;
        }
        return NULL;
    }

    public function deleteUser($user_id) {
        $user = $this->getUserById($user_id);
        try {
            $this->em->remove($user);
            $this->em->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function isAdmin() {
        if($this->securityContext->isGranted('ROLE_ADMIN')) {
            return true;
        }
        return false;
    }
}
