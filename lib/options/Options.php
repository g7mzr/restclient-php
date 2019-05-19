<?php
/**
 * This file is part of RESTCLIENT.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package restclient-php
 * @subpackage http
 * @author   Sandy McNeil <g7mzrdev@gmail.com>
 * @copyright (c) 2019, Sandy McNeil
 * @license https://github.com/g7mzr/restclient-php/blob/master/LICENSE GNU General Public License v3.0
 *
 */

namespace g7mzr\restclient\options;

use \g7mzr\restclient\RestOptions;
use g7mzr\restclient\common\Version;

/**
 * Options Class
 *
 * Options Class is used to set the main configuration for RESTCLIENT
 *
 */
class Options implements RestOptions
{
    /**
     * Property: options
     * @var array
     * @access private
     */
    private $options;

    /**
     * Options Class Constructor
     *
     * Sets up Options Class
     *
     * @access public
     */
    public function __construct()
    {
        $this->options = array();
    }

    /**
     * setBaseURL Method
     *
     * This method sets the base URL of the RESTFull API
     *
     * @param string $url The base url of the Restfull API.
     *
     * @return RestOptions Pointer to the RestOptions Instance being accessed
     *
     * @access public
     */
    public function setBaseURL(string $url)
    {
        if ($url[strlen($url) - 1] != "/") {
            $url .= '/';
        }
        $this->set(RestOptionsType::REST_BASE_URL, $url);
        return $this;
    }

    /**
     * getBaseURL Method
     *
     * This method returns URL base URL of the RESTFull API
     *
     * @return string Base URL
     *
     * @access public
     */
    public function getBaseURL()
    {
        return $this->get(RestOptionsType::REST_BASE_URL, '');
    }

    /**
     * setProxy Address Method
     *
     * This method sets the address of the proxy server used by the RestFull Client
     *
     * @param string $address The address of the proxy server.
     *
     * @return RestOptions Pointer to the RestOptions Instance being accessed.
     *
     * @access public
     */
    public function setProxyServer(string $address)
    {
        $this->set(RestOptionsType::REST_PROXY_SERVER, $address);
        return $this;
    }

    /**
     * getProxy Method
     *
     * This method returns the address of the Proxy Server
     *
     * @return string Proxy Server Address.
     *
     * @access public
     */
    public function getProxyServer()
    {
        return $this->get(RestOptionsType::REST_PROXY_SERVER, '');
    }

    /**
     * setProxyServerPort Method
     *
     * This method sets the port used to connect to the proxy server
     *
     * @param string $port The proxy server port.
     *
     * @return RestOptions Pointer to the RestOptions Instance being accessed.
     *
     * @access public
     */
    public function setProxyServerPort(string $port)
    {
        $this->set(RestOptionsType::REST_PROXY_PORT, $port);
        return $this;
    }

    /**
     * getProxyServerPort Method
     *
     * This method returns the port used by the Proxy Server
     *
     * @return string Proxy Server port.
     *
     * @access public
     */
    public function getProxyServerPort()
    {
        return $this->get(RestOptionsType::REST_PROXY_PORT, '');
    }

    /**
     * setUSerAgent Method
     *
     * This method sets the User AGent String sent to the server
     *
     * @param string $useragent The user agent string sent to the server.
     *
     * @return RestOptions Pointer to the RestOptions Instance being accessed.
     *
     * @access public
     */
    public function setUserAgent(string $useragent)
    {
        $this->set(RestOptionsType::REST_USER_AGENT, $useragent);
        return $this;
    }

    /**
     * getUserAgent Method
     *
     * This method returns the user agent string
     *
     * @return string User Agent String
     *
     * @access public
     */
    public function getUserAgent()
    {
        return $this->get(RestOptionsType::REST_USER_AGENT, Version::USERAGENT);
    }

    /**
     * setCookieFile Method
     *
     * This method sets the local filename for saving cookies.
     *
     * @param string $cookiefile The name of the local file used to stire cookies.
     *
     * @return RestOptions Pointer to the RestOptions Instance being accessed.
     *
     * @access public
     */
    public function setCookieFile(string $cookiefile)
    {
        $this->set(RestOptionsType::REST_COOKIE_FILE, $cookiefile);
        return $this;
    }

    /**
     * getCookiefile Method
     *
     * This method returns The name of the local file used to stire cookies.
     *
     * @return string The name of the local file used to stire cookies.
     *
     * @access public
     */
    public function getCookiefile()
    {
        return $this->get(RestOptionsType::REST_COOKIE_FILE, "");
    }












    /**
     * This function saves the option in the options array
     *
     * This function saves the option in the options array
     *
     * @param string $key   The name of the data to be saved in the options array.
     * @param mixed  $value The value of the data to be saved in the options array.
     *
     * @return RestOptions
     *
     * @access private
     */
    private function set(string $key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * This function retrieves the option in the options array.
     *
     * This function retrieves the option in the options array.
     *
     * @param string $key     The name of the data to be retrieved from the options array.
     * @param mixed  $default The default value of the option type.
     *
     * @return mixed The option data from the options array.
     *
     * @access private
     */
    private function get(string $key, $default = null)
    {
        return isset($this->options[$key])
            ? $this->options[$key]
            : $default;
    }
}
