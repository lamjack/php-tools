<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 15/9/17
 * Time: 下午1:24
 */

namespace Util;


abstract class Path
{
    public static function getRelatePath($path, $firstUrl = null)
    {
        $pathArr = explode('/', $path);
        $firstArr = explode('/', $firstUrl);
        for ($i = 0; $i < count($pathArr); $i++) {
            if ($firstArr[$i] != $pathArr[$i] && $firstArr[$i] != '') {
                return false;
            }
            if (count($firstArr) == $i + 1) {
                $i = $firstArr[$i] == '' ? $i : $i + 1;
                $arr = array();
                while ($i < count($pathArr)) {
                    $arr = $arr + array_slice($pathArr, $i);
                    $i++;
                }
                return $arr ? ($firstUrl == '/' ? $path : implode("/", $arr)) : null;
            }
        }
        return $path;

    }
}