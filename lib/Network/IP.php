<?php
/**
 * IP.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    jack <jack@wizmacau.com>
 * @copyright 2007-2017/7/17 WIZ TECHNOLOGY
 * @link      https://wizmacau.com
 * @link      https://lamjack.github.io
 * @link      https://github.com/lamjack
 * @version
 */

namespace Network;

/**
 * Class IP
 * @package Network
 */
abstract class IP
{
    /**
     * 获取CIDR方式IP段
     *
     * @param string $cidr
     * @return array
     */
    static public function cidrToRange($cidr)
    {
        $range = [];
        $cidr = explode('/', $cidr);
        $range[0] = long2ip((ip2long($cidr[0])) & ((-1 << (32 - (int)$cidr[1]))));
        $range[1] = long2ip((ip2long($range[0])) + pow(2, (32 - (int)$cidr[1])) - 1);
        return $range;
    }
}