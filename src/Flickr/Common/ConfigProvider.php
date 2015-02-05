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
        $args['method'] = $method;
        $args['api_key'] = self::getConfig()->api->key;
        $args['format'] = 'rest';

        return self::getConfig()->api->url . "?" . http_build_query($args);
    }
}