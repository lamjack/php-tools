<?php
/**
 * Author: jack<linjue@wilead.com>
 * Date: 15/10/11
 */

namespace Util;

/**
 * 常用验证类
 *
 * Class Validator
 * @package Util
 */
class Validator
{
    /**
     * 验证手机号码
     *
     * @param string $mobile
     *
     * @return boolean
     */
    static public function validMobileNumber($mobile)
    {
        return preg_match('/^1[3458][0-9]{9}$/', $mobile) > 0;
    }

    static public function validEnglishString($string)
    {
        return preg_match("/^[A-Za-z]+$/", $string) > 0;
    }
}