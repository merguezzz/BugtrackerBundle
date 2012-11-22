<?php

namespace Webaccess\BugtrackerBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends EntityRepository
{
	public function getTotalNumber() {
		return $this->createQueryBuilder('p')
			->select('COUNT(p)')
			->getQuery()
			->getSingleScalarResult();
	}
}