<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 04/02/15
 * Time: 23:02
 */

namespace Flickr\Service;

use Flickr\Common\ConfigProvider;

/**
 * Class for the Flickr Api
 *
 * Class ApiService
 * @package Flickr\Service
 */
class ApiService
{
    public $lastPageCount;
    public $lastPerPage;

    /**
     * Returns parsed XML data from Flickr API search
     *
     * @param $searchString
     * @param int $perPage
     * @param int $page
     * @return mixed
     */
    public function searchImages($searchString, $perPage = 20, $page = 1)
    {
        $args = [
            "per_page" => $perPage,
            "page" => $page,
            "text" => $searchString
        ];

        $url = ConfigProvider::getUrl(ConfigProvider::API_METHOD_SEARCH, $args);

        $file = \file_get_contents($url);
        $results = simplexml_load_string($file);

        $this->lastPageCount = $results->photos['pages'];
        $this->lastPerPage = $results->photos['perpage'];

        return $results->photos->photo;
    }

    /**
     * Util for building an image src url
     *
     * @param $photo
     * @return string
     */
    public static function getImageSrc($photo)
    {
        $url = "http://farm" . $photo['farm'];
        $url .= ".staticflickr.com/" . $photo['server'];
        $url .= "/" . $photo['id'] . "_" . $photo['secret'] . "_t.jpg";
        return $url;
    }

    /**
     * Util for building an images details url
     *
     * @param $photo
     * @return string
     */
    public static function getPhotoDetailsUrl($photo)
    {
        $url = "https://www.flickr.com/photos/" . $photo['owner'];
        $url .= "/" . $photo["id"];
        return $url;
    }
}