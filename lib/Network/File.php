<?php
/**
 * File.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    jack <linjue@wilead.com>
 * @copyright 2007-16/1/10 WIZ TECHNOLOGY
 * @link      http://wizmacau.com
 * @link      http://jacklam.it
 * @link      https://github.com/lamjack
 * @version
 */

namespace Network;

/**
 * Class File
 * @package Network
 */
abstract class File
{
    /**
     * Get Headers function
     *
     * @param string $url
     *
     * @return array
     */
    static public function getHeaders($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        curl_exec($ch);
        $headers = curl_getinfo($ch);
        curl_close($ch);

        return $headers;
    }

    /**
     * Download
     *
     * @param string $url
     * @param string $path
     *
     * @return bool
     */
    static public function download($url, $path)
    {
        # open file to write
        $fp = fopen($path, 'w+');
        # start curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        # set return transfer to false
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        # increase timeout to download big file
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        # write data to local file
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // That's the clue!
        # execute curl
        curl_exec($ch);
        # close curl
        curl_close($ch);
        # close local file
        fclose($fp);

        return filesize($path) > 0;
    }
}