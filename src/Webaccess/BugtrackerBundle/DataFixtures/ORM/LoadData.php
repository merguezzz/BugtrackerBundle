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
        $role1 = new Role();
        $role1->setName('ROLE_ADMIN');

        $role2 = new Role();
        $role2->setName('ROLE_USER');

        $manager->persist($role1);
        $manager->persist($role2);
        $manager->flush();

    	$company1 = new Company();
    	$company1->setName('Webaccess');

    	$company2 = new Company();
    	$company2->setName('Lzaweb');

        $manager->persist($company1);
        $manager->persist($company2);
        $manager->flush();

    	$project1 = new Project();
    	$project1->setCompany($company1);
    	$project1->setName('First Project');

    	$project2 = new Project();
    	$project2->setCompany($company1);
    	$project2->setName('Second Project');

    	$project3 = new Project();
    	$project3->setCompany($company2);
    	$project3->setName('First Project');

        $manager->persist($project1);
        $manager->persist($project2);
        $manager->persist($project3);
        $manager->flush();

        $user1 = new User();
        $user1->setUsername('lgandelin');
        $factory = $this->container->get('security.encoder_factory');
		$encoder = $factory->getEncoder($user1);
		$password = $encoder->encodePassword('GRVnfc38', $user1->getSalt());
		$user1->setPassword($password);
		$user1->setFirstName('Louis');
        $user1->setLastName('Gandelin');
		$user1->setEmail('louis.gandelin@gmail.com');
		$user1->setCompany($company1);
		$user1->addRole($role1);

		$user2 = new User();
        $user2->setUsername('dfontaine');
        $factory = $this->container->get('security.encoder_factory');
		$encoder = $factory->getEncoder($user2);
		$password = $encoder->encodePassword('azeqsd123', $user2->getSalt());
		$user2->setPassword($password);
		$user2->setFirstName('Damien');
		$user2->setLastName('Fontaine');
        $user2->setEmail('louis.gandelin@gmail.com');
		$user2->setCompany($company1);
		$user2->addRole($role2);

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();
    }
}