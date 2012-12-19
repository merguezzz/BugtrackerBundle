<?php

/**
 * Pagination class file
 *
 * PHP 5.3
 *
 * @category Utility
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
namespace Webaccess\BugtrackerBundle\Utility;

/**
 * Pagination class
 *
 * @category Utility
 * @package  WebaccessBugtrackerBundle
 * @author   Louis Gandelin <lgandelin@web-access.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.web-access.fr
 *
 */
class Pagination
{
    /**
     * Pagination function
     *
     * @param integer $pageNumber         Page number
     * @param integer $totalNumber        Total number of items
     * @param integer $itemsPerPageNumber Number of items to display per page
     *
     * @return StdClass Pagination
     */
    static public function getPagination($pageNumber, $totalNumber, $itemsPerPageNumber)
    {
        if ($itemsPerPageNumber > 0) {
            $totalPageNumber = ceil($totalNumber / $itemsPerPageNumber);
        }

        if (is_numeric($pageNumber)) {
            $currentPage = intval($pageNumber);
            if ($currentPage > $totalPageNumber) {
                $currentPage = $totalPageNumber;
            }
        } else {
            $currentPage = 1;
        }

        $itemsOffset = ($currentPage - 1) * $itemsPerPageNumber;
        if($itemsOffset < 0) {
            $itemsOffset = 0;
        }

        $pagination = new \StdClass();
        $pagination->currentPage = $currentPage;
        $pagination->totalPageNumber = $totalPageNumber;
        $pagination->itemsPerPageNumber = $itemsPerPageNumber;
        $pagination->itemsOffset = $itemsOffset;

        return $pagination;
    }
}
