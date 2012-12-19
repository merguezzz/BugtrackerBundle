<?php

/**
 * CompanyRepository class file
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
 * CompanyRepository class
 *
 * @category Repository
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class CompanyRepository extends EntityRepository
{
    /**
     * Function which returns the total number of companies in DB
     *
     * @return integer
     */
    public function getTotalNumber()
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
