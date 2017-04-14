<?php
/**
 * Math.php
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * @author    jack <linjue@wilead.com>
 * @copyright 2007-2017/4/14 WIZ TECHNOLOGY
 * @link      https://wizmacau.com
 * @link      https://lamjack.github.io
 * @link      https://github.com/lamjack
 * @version
 */

namespace Util;

/**
 * Class Math
 * @package Util
 */
abstract class Math
{
    /**
     * 排列运算
     *
     * @param array  $collection
     * @param int    $length
     * @param array  $result
     * @param string $str
     */
    static public function arrangement(array $collection, $length, array &$result, $str = '')
    {
        $count = count($collection);

        if ($length === 0) {
            $result[] = $str;
        } else {
            for ($i = 0; $i < $count; $i++) {
                $item = array_shift($collection);

                if (strlen($str) === 0)
                    $tmp = $item;
                else
                    $tmp = $str . ',' . $item;

                self::arrangement($collection, $length - 1, $result, $tmp);
                array_push($collection, $item);
            }
        }
    }

    /**
     * 组合运算
     *
     * @param array  $collection
     * @param int    $length
     * @param array  $result
     * @param string $str
     */
    static public function combination(array $collection, $length, array &$result, $str = '')
    {
        $count = count($collection);

        if ($length === 0) {
            $result[] = $str;
        } else {
            for ($i = 0; $i < $count - $length + 1; $i++) {
                $item = array_shift($collection);

                if (strlen($str) === 0)
                    $tmp = $item;
                else
                    $tmp = $str . ',' . $item;

                self::combination($collection, $length - 1, $result, $tmp);
            }
        }
    }
}