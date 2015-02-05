<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 05/02/15
 * Time: 19:22
 */

namespace Flickr;

/**
 * Builds pagination HTML
 *
 * Class Pagination
 * @package Flickr
 */
class Pagination
{
    /**
     * Calculates the previous page
     *
     * @param $currentPage
     * @return int
     */
    protected static function getLastPage($currentPage)
    {
        return ($currentPage <= 1) ? 1 : $currentPage - 1;
    }

    /**
     * Calculates the next page
     *
     * @param $currentPage
     * @param $pageTotal
     * @return mixed
     */
    protected static function getNextPage($currentPage, $pageTotal)
    {
        return ($currentPage >= $pageTotal) ? $pageTotal : $currentPage + 1;
    }

    /**
     * Builds pagination in html
     *
     * @param $criteria
     * @param $page
     * @param $perPage
     * @param $pageTotal
     * @return string
     */
    public static function buildPagination($criteria, $page, $perPage, $pageTotal)
    {
        $lastPageArgs = [
            "criteria" => $criteria,
            "per_page" => $perPage,
            "page" => self::getLastPage($page)
        ];

        $pagination = '<a href="index.php?' . http_build_query($lastPageArgs) . '"><</a>';

        if($page <= 5) {

            $paginationStart = 1;
            $paginationEnd = 9;

        } else {

            $paginationStart = $page - 4;
            $paginationEnd = $page + 4;

        }

        for($i = $paginationStart; $i <= $paginationEnd; $i++) {
            $pageArgs = [
                "criteria" => $criteria,
                "per_page" => $perPage,
                "page" => $i
            ];

            if($page == $i) {
                $pagination .= '<span>' . $i . '</span>';
            } else {
                $pagination .= '<a href="index.php?' . http_build_query($pageArgs) . '">' . $i . '</a>';
            }
        }

        $nextPageArgs = [
            "criteria" => $criteria,
            "per_page" => $perPage,
            "page" => self::getNextPage($page, $pageTotal)
        ];

        $pagination .= '<a href="index.php?' . http_build_query($nextPageArgs) . '">></a>';

        return $pagination;
    }

    public static function buildCountSelector($currentPerPage = 10) {
        $values = [10, 25, 50, 100];

        $html = "<select name='per_page'>";

        foreach($values as $value) {
            if($value == $currentPerPage) {
                $html .= "<option value='" . $value . "' selected>" . $value . "</option>";
            } else {
                $html .= "<option value='" . $value . "'>" . $value . "</option>";
            }

        }

        $html .= "</select>";

        return $html;
    }
}