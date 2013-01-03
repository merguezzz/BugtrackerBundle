<?php

/**
 * UserRepository class file
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
 * UserRepository class
 *
 * @category Repository
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class UserRepository extends EntityRepository
{
    /**
     * Function which returns the total number of users in DB
     *
     * @return integer
     */
    public function getTotalNumber()
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Function which returns users by project
     *
     * @param integer $projectId Project ID
     *
     * @return QueryBuilder
     */
    public function findByProject($projectId, $userId, $isAdmin)
    {
        $qb = $this->createQueryBuilder('u')
            ->addSelect('c')
            ->orderBy('u.lastName', 'ASC')
            ->orderBy('u.firstName', 'ASC')
            ->leftJoin('u.projects', 'p')
            ->leftJoin('u.company', 'c');

        if ($projectId) {
            $qb->andWhere($this->createQueryBuilder('u')->expr()->eq('p.id', $projectId));
        } elseif($userId) {
            if (!$isAdmin) {
                $qb->leftJoin('p.users', 'user')
                    ->where($qb->expr()->eq('user.id', $userId));
            }
        }

        return $qb;
    }

    /**
     * Function which returns users by company
     *
     * @param integer $companyId Company ID
     * @param integer $isAdmin   True if the user is an admin
     *
     * @return QueryBuilder
     */
    public function getByCompany($companyId, $isAdmin)
    {
        $qb = $this->createQueryBuilder('u')
            ->orderBy('u.lastName', 'ASC')
            ->orderBy('u.firstName', 'ASC');

        if (!$isAdmin) {
            $qb->leftJoin('u.company', 'company')
                ->where($qb->expr()->eq('company.id', $companyId));
        }

        return $qb;
    }
}
