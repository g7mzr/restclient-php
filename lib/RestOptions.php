<?php
/**
 * This file is part of  RESTCLIENT.
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

namespace g7mzr\restclient;

/**
 * Options Class
 *
 * Options Class is used to set the main configuration for RESTCLIENT
 *
 */
interface RestOptions
{
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
    public function setBaseURL(string $url);

    /**
     * getBaseURL Method
     *
     * This method returns URL base URL of the RESTFull API
     *
     * @return string Base URL
     *
     * @access public
     */
    public function getBaseURL();

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
    public function setProxyServer(string $address);

    /**
     * getProxy Method
     *
     * This method returns the address of the Proxy Server
     *
     * @return string Proxy Server Address.
     *
     * @access public
     */
    public function getProxyServer();

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
    public function setProxyServerPort(string $port);

    /**
     * getProxyServerPort Method
     *
     * This method returns the port used by the Proxy Server
     *
     * @return string Proxy Server port.
     *
     * @access public
     */
    public function getProxyServerPort();

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
    public function setUserAgent(string $useragent);

    /**
     * getUserAgent Method
     *
     * This method returns the user agent string
     *
     * @return string User Agent String
     *
     * @access public
     */
    public function getUserAgent();

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
    public function setCookieFile(string $cookiefile);

    /**
     * getCookiefile Method
     *
     * This method returns The name of the local file used to stire cookies.
     *
     * @return string The name of the local file used to stire cookies.
     *
     * @access public
     */
    public function getCookiefile();
}
