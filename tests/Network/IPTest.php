<?php
/**
 * IPTest.php
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

namespace tests\Network;

use Network\IP;
use PHPUnit\Framework\TestCase;

/**
 * Class IPTest
 * @package tests\Network
 */
class IPTest extends TestCase
{
    /**
     * @expectedException \ArithmeticError
     */
    public function testCidrToRange()
    {
        $ips = IP::cidrToRange('192.168.0.0/16');
        $this->assertCount(pow(2, 32 - 16), $ips);
        $this->assertContains('192.168.0.100', $ips);
        $this->assertNotContains('192.169.0.1', $ips);

        $this->assertCount(pow(2, 32 - 24), IP::cidrToRange('192.168.0.0/24'));
        $this->assertEquals(IP::cidrToRange('192.168.0.1'), '192.168.0.1');

        $this->expectException(IP::cidrToRange('192.168.0.0/35'));
    }
}