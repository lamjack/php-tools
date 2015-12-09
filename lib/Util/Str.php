<?php
/**
 * Author: jack<linjue@wilead.com>
 * Date: 15/8/4
 */

namespace Util;

/**
 * Class Str
 * @package Util
 */
class Str
{
    /**
     * 駝峰式字符串轉下劃線式
     *
     * @param string $str
     * @param boolean $replace
     *
     * @return string
     */
    static public function camelToUnderscore($str, $replace = false)
    {
        $str = preg_replace('/(?<=\w)([A-Z])(?=[a-z]+)/', "_$1", trim($str));
        $str = $replace ? str_replace(" ", "_", $str) : $str;
        return strtolower($str);
    }

    /**
     * 下劃線式字符串轉駝峰式
     *
     * @param string $str
     * @param bool $capitalise_first_char 首字母是否大寫
     *
     * @return mixed
     */
    static public function underscoreToCamel($str, $capitalise_first_char = false, $space = false)
    {
        if ($capitalise_first_char) {
            $str[0] = strtoupper($str[0]);
        }
        $func = $space ? 'return " " . strtoupper($c[1]);' : 'return strtoupper($c[1]);';
        $callback = create_function('$c', $func);
        return preg_replace_callback('/_([a-z])/', $callback, $str);
    }

    /**
     * 产生随机字符串
     *
     * @param $length
     *
     * @return string
     */
    static public function randomStr($length)
    {
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $strlen = 62;
        while ($length > $strlen) {
            $str .= $str;
            $strlen += 60;
        }
        $str = str_shuffle($str);
        return substr($str, 0, $length);
    }

    /**
     * 产生唯一字符串
     *
     * @param string $prefix
     * @param int $length
     *
     * @return string
     */
    static public function generateUniqidString($prefix = '', $length = 20)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return uniqid($prefix) . $key;
    }

    /**
     * 检查文本是否utf8编码
     *
     * @param $string
     *
     * @return bool
     */
    static public function isUTF8($string)
    {
        for ($idx = 0, $strlen = strlen($string); $idx < $strlen; $idx++) {
            $byte = ord($string[$idx]);

            if ($byte & 0x80) {
                if (($byte & 0xE0) == 0xC0) {
                    $bytes_remaining = 1;
                } else if (($byte & 0xF0) == 0xE0) {
                    $bytes_remaining = 2;
                } else if (($byte & 0xF8) == 0xF0) {
                    $bytes_remaining = 3;
                } else {
                    return false;
                }

                if ($idx + $bytes_remaining >= $strlen) {
                    return false;
                }

                while ($bytes_remaining--) {
                    if ((ord($string[++$idx]) & 0xC0) != 0x80) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /**
     * 获取随机密码
     *
     * @param int $length
     *
     * @return string
     */
    static public function passwordGenerator($length = 8)
    {
        if ($length > 32)
            $length = 32;

        return substr(md5(microtime()), 0, $length);
    }
}