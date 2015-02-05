<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 04/02/15
 * Time: 23:02
 */

namespace Flickr\Service;

use Flickr\Common\ConfigProvider;

class ApiService {

    public function searchImages($searchString, $perPage = 20, $page = 1) {
        $args = [
            "per_page" => $perPage,
            "page" => $page,
            "text" => $searchString
        ];

        $url = ConfigProvider::getUrl(ConfigProvider::API_METHOD_SEARCH, $args);

        echo $url;

        $file = \file_get_contents($url);
        $results = simplexml_load_string($file);

        var_dump($results);

        $output = [];
        foreach($results->photos->photo as $result) {
            $url = "http://farm" . $result['farm'];
            $url .= ".staticflickr.com/" . $result['server'];
            $url .= "/" . $result['id'] . "_" . $result['secret'] . "_t.jpg";
            $output[] = $url;
        }

        return $output;
    }
}