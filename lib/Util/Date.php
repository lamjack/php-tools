<?php
/**
 * Date.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    jack <linjue@wilead.com>
 * @copyright 2007-2016/11/1 WIZ TECHNOLOGY
 * @link      https://wizmacau.com
 * @link      https://lamjack.github.io
 * @link      https://github.com/lamjack
 * @version
 */

namespace Util;

/**
 * Class Date
 * @package Util
 */
abstract class Date
{
    /**
     * @var int
     */
    const SECOND = 1;

    /**
     * @var int
     */
    const MINUTE = 60 * self::SECOND;

    /**
     * @var int
     */
    const HOUR = 60 * self::MINUTE;

    /**
     * @var int
     */
    const DAY = 24 * self::HOUR;

    /**
     * @var int
     */
    const MONTH = 30 * self::DAY;

    /**
     * @var int
     */
    const YEAR = 12 * self::MONTH;

    /**
     * get friendly time string
     *
     * @param int $time
     *
     * @return array|string
     */
    public static function friendly($time)
    {
        $now = time();
        $delta = abs($time - $now);

        if ($delta < self::MINUTE) {
            return $delta === self::SECOND ? 'one second age' : ['%num% second ago', $delta];
        }

        if ($delta < 2 * self::MINUTE) {
            return 'a minute ago';
        }

        if ($delta < 45 * self::MINUTE) {
            return ['%num% minutes ago', (int)($delta / self::MINUTE)];
        }

        if ($delta < 90 * self::MINUTE) {
            return 'an hour ago';
        }

        if ($delta < 24 * self::HOUR) {
            return ['%num% hours ago', (int)($delta / self::HOUR)];
        }

        if ($delta < 48 * self::HOUR) {
            return 'yesterday';
        }

        if ($delta < self::MONTH) {
            return ['%num% days ago', (int)($delta / self::DAY)];
        }

        if ($delta < self::YEAR) {
            $months = (int)($delta / self::MONTH);
            return $months <= 1 ? 'one month ago' : ['%num% months ago', [$months]];
        }

        $years = (int)($delta / self::YEAR);
        return $years <= 1 ? 'one year ago' : ['%num% years ago', [$years]];
    }
}