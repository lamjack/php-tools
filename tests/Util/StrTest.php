<?php
/**
 * StrTest.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    jack <jack@wizmacau.com>
 * @copyright 2007-2017/9/20 WIZ TECHNOLOGY
 * @link      https://wizmacau.com
 * @link      https://lamjack.github.io
 * @link      https://github.com/lamjack
 * @version
 */

namespace tests\Util;

use PHPUnit\Framework\TestCase;
use Util\Str;

/**
 * Class StrTest
 * @package tests\Util
 */
class StrTest extends TestCase
{
    public function testExtractDomainFromEmail()
    {
        $data = [
            'test@wizmacau.com' => 'wizmacau.com',
            'test+1@wizmacau.com' => 'wizmacau.com',
            'test@yahoo.com.hk' => 'yahoo.com.hk',
            'test@hotmail.com' => 'hotmail.com',
            'test@yahoo.com' => 'yahoo.com',
            'test@@yahoo.com' => null,
            'test@test' => null
        ];

        foreach ($data as $email => $domain) {
            $result = Str::extractDomainFromEmail($email);
            $this->assertEquals($result, $domain);
        }
    }

    public function testResolveNginxStatus()
    {
        $str = <<<EOD
Active connections: 100
server accepts handled requests
 10000 20000 30000
Reading: 0 Writing: 1 Waiting: 0
EOD;
        $result = Str::resolveNginxStatus($str);
        $this->assertCount(7, $result);
    }
}