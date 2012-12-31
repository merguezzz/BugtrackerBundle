<?php
namespace Webaccess\BugtrackerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Webaccess\BugtrackerBundle\Entity\Company;
use Webaccess\BugtrackerBundle\Entity\Project;
use Webaccess\BugtrackerBundle\Entity\User;
use Webaccess\BugtrackerBundle\Entity\Role;
use Webaccess\BugtrackerBundle\Entity\Ticket;
use Webaccess\BugtrackerBundle\Entity\TicketState;

class LoadData implements FixtureInterface, ContainerAwareInterface
{
	/**
	* @var ContainerInterface
	*/
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        //ROLES
        $role1 = new Role();
        $role1->setName('ROLE_ADMIN');

        $role2 = new Role();
        $role2->setName('ROLE_USER');

        $manager->persist($role1);
        $manager->persist($role2);
        $manager->flush();

        //COMPANIES
    	$company1 = new Company();
    	$company1->setName('Company 1');

    	$company2 = new Company();
    	$company2->setName('Company2');

        $manager->persist($company1);
        $manager->persist($company2);
        $manager->flush();

        //PROJECTS
    	$project1 = new Project();
    	$project1->setCompany($company1);
    	$project1->setName('Project 1');

    	$project2 = new Project();
    	$project2->setCompany($company1);
    	$project2->setName('Project 2');

    	$project3 = new Project();
    	$project3->setCompany($company2);
    	$project3->setName('Project 3');

        $manager->persist($project1);
        $manager->persist($project2);
        $manager->persist($project3);
        $manager->flush();

        //USERS
        $user1 = new User();
        $user1->setUsername('john');
        $factory = $this->container->get('security.encoder_factory');
		$encoder = $factory->getEncoder($user1);
		$password = $encoder->encodePassword('111aaa', $user1->getSalt());
		$user1->setPassword($password);
		$user1->setFirstName('John');
        $user1->setLastName('');
		$user1->setEmail('john@company1.com');
		$user1->setCompany($company1);
		$user1->addRole($role1);

		$user2 = new User();
        $user2->setUsername('jack');
        $factory = $this->container->get('security.encoder_factory');
		$encoder = $factory->getEncoder($user2);
		$password = $encoder->encodePassword('222bbb', $user2->getSalt());
		$user2->setPassword($password);
		$user2->setFirstName('Jack');
		$user2->setLastName('');
        $user2->setEmail('jack@company1.com');
		$user2->setCompany($company1);
		$user2->addRole($role2);
        $user1->addProject($project1);
        $user1->addProject($project2);
        $user2->addProject($project1);
        $user2->addProject($project3);

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();

        //TICKETS
        $ticket1 = new Ticket();
        $ticket1->setProject($project1);
        $ticket1->setTitle('Bug found in home page');

        $ticket2 = new Ticket();
        $ticket2->setProject($project2);
        $ticket2->setTitle('Another bug found in home page');

        $manager->persist($ticket1);
        $manager->persist($ticket2);
        $manager->flush();

        //TICKET STATES
        $ticket_state1 = new TicketState();
        $ticket_state1->setTicket($ticket1);
        $ticket_state1->setAuthorUser($user1);
        $ticket_state1->setAllocatedUser($user1);
        $ticket_state1->setStatus(1);
        $ticket_state1->setPriority(1);
        $ticket_state1->setType(1);

        $manager->persist($ticket_state1);
        $ticket1->addState($ticket_state1);
        $ticket1->setCurrentState($ticket_state1);

        $ticket_state2 = new TicketState();
        $ticket_state2->setTicket($ticket2);
        $ticket_state2->setAuthorUser($user1);
        $ticket_state2->setAllocatedUser($user2);
        $ticket_state2->setStatus(1);
        $ticket_state2->setPriority(1);
        $ticket_state2->setType(1);

        $manager->persist($ticket_state1);
        $ticket1->addState($ticket_state1);
        $manager->persist($ticket_state2);
        $ticket2->addState($ticket_state2);
        $ticket2->setCurrentState($ticket_state2);

        $manager->flush();
    }
}
