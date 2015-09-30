<?php
/**
 * Author: jack<linjue@wilead.com>
 * Date: 15/9/30
 */

namespace Network;

/**
 * Class Url
 * @package Network
 */
class Url
{
    /**
     * 析一个URL并返回一个关联数组,包含在URL中出现的所有组成部分。
     *
     * @param string $url
     *
     * @return array
     */
    static public function parseUrl($url)
    {
        $urlArr = parse_url($url);

        if (array_key_exists('scheme', $urlArr) && !array_key_exists('port', $urlArr)) {
            switch ($urlArr['scheme']) {
                case 'http':
                    $urlArr['port'] = 80;
                    break;
                case 'https':
                    $urlArr['port'] = 443;
                    break;
            }
        }

        return $urlArr;
    }
}