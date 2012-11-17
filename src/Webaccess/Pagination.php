<?php

namespace Webaccess\CMSBundle\Utility;

class Pagination {

	static public function getPagination($page_number, $total_number, $items_per_page_number)
    {
        $total_page_number = ceil($total_number / $items_per_page_number);

        if(is_numeric($page_number)) {
            $current_page = intval($page_number);
             
            if($current_page > $total_page_number) {
                $current_page = $total_page_number;
            }
        } else {
            $current_page = 1;
        }

        $pagination = new \StdClass();
        $pagination->current_page = $current_page;
        $pagination->total_page_number = $total_page_number;
        $pagination->items_per_page_number = $items_per_page_number;
        $pagination->items_offset = ($pagination->current_page - 1) * $pagination->items_per_page_number;
        if($pagination->items_offset < 0) $pagination->items_offset = 0;
        
        return $pagination;
    }
}