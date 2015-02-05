<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 05/02/15
 * Time: 19:22
 */

namespace Flickr;

/**
 * Builds HTML for pagination
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
     * Builds last paginate button
     *
     * @param $criteria
     * @param $perPage
     * @param $page
     * @return string
     */
    protected static function buildLastPaginate($criteria, $perPage, $page)
    {
        $lastPageArgs = [
            "criteria" => $criteria,
            "per_page" => $perPage,
            "page" => self::getLastPage($page)
        ];

        if ($page > 1) {
            $pagination = '<a href="index.php?' . http_build_query($lastPageArgs) . '"><</a>';
        } else {
            $pagination = '<span><</span>';
        }

        return $pagination;
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
     * Builds next button
     *
     * @param $criteria
     * @param $perPage
     * @param $page
     * @param $pageTotal
     * @return string
     */
    public static function buildNextPaginate($criteria, $perPage, $page, $pageTotal)
    {
        $nextPageArgs = [
            "criteria" => $criteria,
            "per_page" => $perPage,
            "page" => self::getNextPage($page, $pageTotal)
        ];

        if ($page != $pageTotal) {
            $pagination = '<a href="index.php?' . http_build_query($nextPageArgs) . '">></a>';
        } else {
            $pagination = '<span>></span>';
        }

        return $pagination;
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
        $pagination = self::buildLastPaginate($criteria, $perPage, $page);

        if ($page <= 5) {
            $paginationStart = 1;
            $paginationEnd = 9;
        } else {
            $paginationStart = $page - 4;
            $paginationEnd = $page + 4;
        }

        for ($i = $paginationStart; $i <= $paginationEnd; $i++) {
            $pageArgs = [
                "criteria" => $criteria,
                "per_page" => $perPage,
                "page" => $i
            ];

            if ($page == $i) {
                $pagination .= '<span>' . $i . '</span>';
            } else {
                $pagination .= '<a href="index.php?' . http_build_query($pageArgs) . '">' . $i . '</a>';
            }

            if ($i == $pageTotal) {
                break;
            }
        }

        $pagination .= self::buildNextPaginate($criteria, $perPage, $page, $pageTotal);

        return $pagination;
    }

    /**
     * Builds PerPage select
     *
     * @param int $currentPerPage
     * @return string
     */
    public static function buildCountSelector($currentPerPage = 10)
    {
        $values = [10, 25, 50, 100];

        $html = "<select name='per_page'>";

        foreach ($values as $value) {
            if ($value == $currentPerPage) {
                $html .= "<option value='" . $value . "' selected>" . $value . "</option>";
            } else {
                $html .= "<option value='" . $value . "'>" . $value . "</option>";
            }

        }

        $html .= "</select>";

        return $html;
    }
}