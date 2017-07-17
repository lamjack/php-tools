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
        $split = explode('/', $cidr);

        if (count($split) > 1 && !empty($split[0]) && is_scalar($split[1]) && filter_var($split[0], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $rangeStart = ip2long($split[0]) & ((-1 << (32 - (int)$split[1])));
            $rangeEnd = ip2long($split[0]) + pow(2, (32 - (int)$split[1])) - 1;

            for ($i = $rangeStart; $i <= $rangeEnd; $i++) {
                $range[] = long2ip($i);
            }
            return $range;
        } else {
            return $cidr;
        }
    }
}