<?php

/**
 * ProjectRepository class file
 *
 * PHP 5.3
 *
 * @category Repository
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
namespace Webaccess\BugtrackerBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ProjectRepository class
 *
 * @category Repository
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class ProjectRepository extends EntityRepository
{
    /**
     * Function which returns the total number of projects in DB
     *
     * @return integer
     */
    public function getTotalNumber()
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Function which returns a project from DB
     *
     * @param integer $userId  User ID
     * @param boolean $isAdmin True if the user is an admin
     *
     * @return QueryBuilder
     */
    public function getByUser($userId, $isAdmin)
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('c')
            ->orderBy('p.name', 'ASC')
            ->leftJoin('p.company', 'c');

        if (!$isAdmin) {
            $qb->leftJoin('p.users', 'user')
                ->where($qb->expr()->eq('user.id', $userId));
        }

        return $qb;
    }
}
