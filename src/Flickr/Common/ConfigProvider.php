<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 05/02/15
 * Time: 00:36
 */

namespace Flickr\Common;

class ConfigProvider {
    const API_METHOD_SEARCH = "flickr.photos.search";

    public static function getConfig() {
        $configFile = file_get_contents("config/config.json");

        return json_decode($configFile);
    }

    public static function getUrl($method, array $args) {
        $url = self::getConfig()->api->url;
        $url .= "?method=" . $method;
        $url .= "&api_key=" . self::getConfig()->api->key;
        $url .= "&format=rest";

        foreach($args as $key => $arg) {
            $url .= "&" . $key . "=" . $arg;
        }

        return $url;
    }
}