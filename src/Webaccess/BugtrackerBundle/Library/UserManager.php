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
	public function __construct($em, EncoderFactory $encoderFactory, $securityContext) {
        $this->em = $em;
        $this->repository = $this->em->getRepository('WebaccessBugtrackerBundle:User');
        $this->encoderFactory = $encoderFactory;
        $this->securityContext = $securityContext;
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

    public function getUser($user_id) {
        $user = $this->repository->find($user_id);
        return ($user) ? $user : false;
    }

    public function getUserInSession() {
        return $this->securityContext->getToken()->getUser();
    }

    public function deleteUser($user_id) {
        $user = $this->getUser($user_id);
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
