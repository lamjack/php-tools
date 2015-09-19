<?php
/**
 * Author: jack<linjue@wilead.com>
 * Date: 15/7/30
 */

namespace Network;

use Util\Json;

/**
 * Class Curl
 * @package Network
 */
class Curl
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';

    /**
     * @var resource cURL handle
     */
    private $curl;

    /**
     * Curl constructor.
     */
    function __construct()
    {
        $this->curl = curl_init();
    }

    /**
     * Make a HTTP GET request
     *
     * @param string $url
     * @param array $params
     * @param array $options
     *
     * @return array
     */
    public function get($url, $params = array(), $options = array())
    {
        return $this->request($url, self::GET, $params, $options);
    }

    /**
     * Make a HTTP POST request
     *
     * @param string $url
     * @param array $params
     * @param array $options
     *
     * @return array
     */
    public function post($url, $params = array(), $options = array())
    {
        return $this->request($url, self::POST, $params, $options);
    }

    /**
     * Make a HTTP PUT request
     *
     * @param string $url
     * @param array $params
     * @param array $options
     *
     * @return array
     */
    public function put($url, $params = array(), $options = array())
    {
        return $this->request($url, self::PUT, $params, $options);
    }

    /**
     * Make a HTTP PATCH request
     *
     * @param string $url
     * @param array $params
     * @param array $options
     *
     * @return array
     */
    public function patch($url, $params = array(), $options = array())
    {
        return $this->request($url, self::PATCH, $params, $options);
    }

    /**
     * Make a HTTP DELETE request
     *
     * @param string $url
     * @param array $params
     * @param array $options
     *
     * @return array
     */
    public function delete($url, $params = array(), $options = array())
    {
        return $this->request($url, self::DELETE, $params, $options);
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $params
     * @param array $options
     *
     * @return array
     */
    protected function request($url, $method = self::GET, $params = array(), $options = array())
    {
        if (in_array($method, array(self::GET, self::DELETE)) && count($params)) {
            $url .= (stripos($url, '?') ? '&' : '?') . http_build_query($params);
            $params = array();
        }

        curl_setopt($this->curl, CURLOPT_HEADER, true);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($this->curl, CURLOPT_URL, $url);

        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 30);

        // File Upload
        if (isset($options['files']) && count($options['files']) > 0) {
            foreach ($options['files'] as $index => $file) {
                $params[$index] = $this->createCurlFile($file);
            }
            version_compare(PHP_VERSION, '5.5', '<') || curl_setopt($this->curl, CURLOPT_SAFE_UPLOAD, false);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
        } elseif (isset($options['json'])) {
            $options['headers'][] = 'content-type:application/json';
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, Json::encode($params));
        } elseif (in_array($method, array(self::POST))) {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($params));
        } else {

        }

        // Check for custom headers
        if (isset($options['headers']) && count($options['headers']))
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, $options['headers']);

        // Check for basic auth
        if (isset($options['auth']['type']) && 'basic' === $options['auth']['type'])
            curl_setopt($this->curl, CURLOPT_USERPWD, $options['auth']['username'] . ':' . $options['auth']['password']);

        $response = $this->doCurl();
        // Separate headers and body
        $headerSize = $response['curl_info']['header_size'];
        $header = substr($response['response'], 0, $headerSize);
        $body = substr($response['response'], $headerSize);
        $results = array(
            'curl_info' => $response['curl_info'],
            'content_type' => $response['curl_info']['content_type'],
            'status' => $response['curl_info']['http_code'],
            'headers' => $this->splitHeaders($header),
            'data' => $body,
        );
        if ($response['response'] === false)
            $results['curl_error'] = curl_error($this->curl);
        return $results;
    }

    /**
     * Make cURL file
     *
     * @param $file
     *
     * @return \CURLFile|string
     */
    protected function createCurlFile($file)
    {
        if (function_exists('curl_file_create')) {
            return curl_file_create($file);
        }
        return sprintf('@%s;filename=%s', $file, basename($file));
    }

    /**
     * Split the HTTP headers
     *
     * @param string $raw_header
     *
     * @return array
     */
    protected function splitHeaders($raw_header)
    {
        $headers = array();
        $lines = explode("\n", trim($raw_header));
        $headers['HTTP'] = array_shift($lines);
        foreach ($lines as $h) {
            $h = explode(':', $h, 2);
            if (isset($h[1])) {
                $headers[$h[0]] = trim($h[1]);
            }
        }
        return $headers;
    }

    /**
     * @return array
     */
    protected function doCurl()
    {
        $response = curl_exec($this->curl);
        $curl_info = curl_getinfo($this->curl);

        $results = array(
            'curl_info' => $curl_info,
            'response' => $response
        );

        return $results;
    }

    /**
     * PHP 5 introduces a destructor concept similar to that of other object-oriented languages, such as C++.
     * The destructor method will be called as soon as all references to a particular object are removed or
     * when the object is explicitly destroyed or in any order in shutdown sequence.
     *
     * Like constructors, parent destructors will not be called implicitly by the engine.
     * In order to run a parent destructor, one would have to explicitly call parent::__destruct() in the destructor body.
     *
     * Note: Destructors called during the script shutdown have HTTP headers already sent.
     * The working directory in the script shutdown phase can be different with some SAPIs (e.g. Apache).
     *
     * Note: Attempting to throw an exception from a destructor (called in the time of script termination) causes a fatal error.
     *
     * @return void
     * @link http://php.net/manual/en/language.oop5.decon.php
     */
    function __destruct()
    {
        if (is_resource($this->curl)) {
            curl_close($this->curl);
        }
    }
}