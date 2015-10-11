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
     * 手机号码验证
     *
     * @param string $mobile
     *
     * @return boolean
     */
    static public function validMobileNumber($mobile)
    {
        return preg_match('/^1[3458][0-9]{9}$/', $mobile) > 0;
    }

    /**
     * 英文字符串验证
     *
     * @param $string
     *
     * @return bool
     */
    static public function validEnglishString($string)
    {
        return preg_match("/^[A-Za-z]+$/", $string) > 0;
    }

    /**
     * 密码格式验证
     *
     * @param string $password
     * @param int $minLength
     * @param int $maxLength
     *
     * @return bool
     */
    static public function validPassword($password, $minLength = 6, $maxLength = 18)
    {
        if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $password)) {
            return false;
        }
        $length = strlen($password);
        if ($length < $minLength || $length > $maxLength) {
            return false;
        }
        return true;
    }
}