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

    /**
     * 邮箱地址格式验证
     *
     * @param $email
     * @return bool
     */
    static public function validEmail($email)
    {
        $isValid = true;
        $atIndex = strrpos($email, "@");
        if (is_bool($atIndex) && !$atIndex) {
            $isValid = false;
        } else {
            $domain = substr($email, $atIndex + 1);
            $local = substr($email, 0, $atIndex);
            $localLen = strlen($local);
            $domainLen = strlen($domain);
            if ($localLen < 1 || $localLen > 64) {
                $isValid = false;
            } else if ($domainLen < 1 || $domainLen > 255) {
                $isValid = false;
            } else if ($local[0] == '.' || $local[$localLen - 1] == '.') {
                $isValid = false;
            } else if (preg_match('/\\.\\./', $local)) {
                $isValid = false;
            } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
                $isValid = false;
            } else if (preg_match('/\\.\\./', $domain)) {
                $isValid = false;
            } else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local))) {
                if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $local))) {
                    $isValid = false;
                }
            }
            if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
                $isValid = false;
            }
        }
        return $isValid;
    }
}