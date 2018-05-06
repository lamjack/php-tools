<?php
/**
 * IDNumber.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    jack <jack@wizmacau.com>
 * @copyright 2007-2018/5/6 WIZ TECHNOLOGY
 * @link      https://wizmacau.com
 * @link      https://lamjack.github.io
 * @link      https://github.com/lamjack
 * @version
 */

namespace Util;

/**
 * Class IDNumber
 * @package Util
 */
abstract class IDNumber
{
    static protected $validateCodes = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];

    /**
     * 根据身份证号码获取性别
     *
     * @param string $id
     *
     * @return null|string M男性,F女性
     */
    static public function getGender($id)
    {
        if (empty($id) || strlen($id) !== 18)
            return null;

        $iSex = (int)substr($id, 16, 1);
        return $iSex % 2 === 0 ? 'F' : 'M';
    }

    /**
     * 验证身份证出生日期是否正确
     *
     * @param string $iY
     * @param string $iM
     * @param string $iD
     *
     * @return bool
     */
    static public function validBirthday($iY, $iM, $iD)
    {
        $iDate = $iY . '-' . $iM . '-' . $iD;
        $rPattern = '/^(([0-9]{2})|(19[0-9]{2})|(20[0-9]{2}))-((0[1-9]{1})|(1[012]{1}))-((0[1-9]{1})|(1[0-9]{1})|(2[0-9]{1})|3[01]{1})$/';
        if (preg_match($rPattern, $iDate, $arr)) {
            return true;
        }
        return false;
    }

    /**
     * 根据身份证号码获取出生日期
     *
     * @param string $id
     *
     * @return null|string 返回XXXX-XX-XX
     */
    static public function getBirthday($id)
    {
        if (empty($id) || strlen($id) !== 18)
            return null;

        $birthdayStr = substr($id, 6, 8);
        $year = substr($birthdayStr, 0, 4);
        $month = substr($birthdayStr, 4, 2);
        $day = substr($birthdayStr, 6, 2);

        return sprintf('%s-%s-%s', $year, $month, $day);
    }

    /**
     * 根据身份证前17位获取最后一位校验码
     *
     * @param string $id
     *
     * @return string|null
     */
    static public function getValidateCode($id)
    {
        if (empty($id) || strlen($id) !== 18)
            return null;

        $id17 = substr($id, 0, 17);
        $sum = 0;
        $len = strlen($id17);
        for ($i = 0; $i < $len; $i++) {
            $sum += $id17[$i] * self::$validateCodes[$i];
        }
        $mode = $sum % 11;
        return self::$validateCodes[$mode];
    }

    /**
     * 根据身份证号码获取省份
     *
     * @param string $id
     *
     * @return string|null
     */
    static public function getProvince($id)
    {
        if (empty($id) || (strlen($id) !== 15 && strlen($id) !== 18))
            return null;

        $index = substr($id, 0, 2);
        $area = [
            11 => "北京", 12 => "天津", 13 => "河北", 14 => "山西", 15 => "内蒙古", 21 => "辽宁",
            22 => "吉林", 23 => "黑龙江", 31 => "上海", 32 => "江苏", 33 => "浙江", 34 => "安徽",
            35 => "福建", 36 => "江西", 37 => "山东", 41 => "河南", 42 => "湖北", 43 => "湖南",
            44 => "广东", 45 => "广西", 46 => "海南", 50 => "重庆", 51 => "四川", 52 => "贵州",
            53 => "云南", 54 => "西藏", 61 => "陕西", 62 => "甘肃", 63 => "青海", 64 => "宁夏",
            65 => "新疆", 71 => "台湾", 81 => "香港", 82 => "澳门", 91 => "国外"
        ];
        return $area[$index];
    }
}