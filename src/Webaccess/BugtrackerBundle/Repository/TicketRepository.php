<?php

/**
 * TicketRepository class file
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
 * TicketRepository class
 *
 * @category Repository
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class TicketRepository extends EntityRepository
{
    /**
     * Function which returns the total number of tickets in DB
     *
     * @return integer
     */
    public function getTotalNumber()
    {
        return $this->createQueryBuilder('t')
            ->select('COUNT(t)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Function which returns tickets by project / allocatedUser / type / status / priority
     *
     * @param integer $userId          User ID
     * @param integer $limit           Query limit
     * @param integer $offset          Query offset
     * @param integer $projectId       Project ID
     * @param integer $allocatedUserId Allocated user ID
     * @param integer $typeId          Type ID
     * @param integer $statusId        Status ID
     * @param integer $priorityId      Priority ID
     *
     * @return QueryBuilder
     */
    public function getByUser($userId, $limit, $offset, $projectId = null, $allocatedUserId = null, $typeId = null, $statusId = null, $priorityId = null)
    {
        $qb = $this->createQueryBuilder('t');

        $qb->addSelect('ts')
            ->addSelect('p')
            ->leftJoin('t.project', 'p')
            ->leftJoin('p.users', 'u')
            ->leftJoin('t.states', 'ts')
            ->andWhere($this->createQueryBuilder('t')->expr()->eq('u.id', $userId));

        if ($allocatedUserId) {
            $qb->andWhere($this->createQueryBuilder('t')->expr()->eq('ts.allocatedUser', $allocatedUserId))
                ->andWhere('ts.id = t.currentState');
        }

        if ($projectId) {
            $qb->andWhere('p.id = :projectId')
                ->setParameter('projectId', $projectId);
        }

        if ($typeId) {
            $qb->andWhere($this->createQueryBuilder('t')->expr()->eq('ts.type', $typeId))
                ->andWhere('ts.id = t.currentState');
        }

        if ($statusId) {
            $qb->andWhere($this->createQueryBuilder('t')->expr()->eq('ts.status', $statusId))
                ->andWhere('ts.id = t.currentState');
        }

        if ($priorityId) {
            $qb->andWhere($this->createQueryBuilder('t')->expr()->eq('ts.priority', $priorityId))
                ->andWhere('ts.id = t.currentState');
        }

        $qb->groupBy('t.id')
            ->orderBy('ts.createdAt', 'desc')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
}
