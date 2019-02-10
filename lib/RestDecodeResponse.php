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

namespace g7mzr\restclient;

/**
 * Response Class
 *
 * Response Class processes the headers and data received from the web server RestFULL
 * API.
 *
 */
interface RestDecodeResponse
{
    /**
     * Get the HTTP response including error status.
     *
     * This function returns the HTTP response as an array.  The first element contains
     * the HTTP version.  The second element contains the status code and the third the
     * status message.
     *
     * @return array The http response
     *
     * @access public
     */
    public function getHTTPResponce();

    /**
     * This function returns the date and time the response was received from the server
     *
     * @return integer The date and time the response was received from the server
     *
     * @access public
     */
    public function getHTTPDate();

    /**
     * This function returns the server description
     *
     * @return string Server description
     *
     * @access public
     */
    public function getServer();

    /**
     * This function returns the X-Powered-By description
     *
     * @return string X-Powered-By description
     *
     * @access public
     */
    public function getXPoweredBy();

    /**
     * This function returns the Access-Control Data Array
     *
     * @return array Access-Control data
     *
     * @access public
     */
    public function getAccessControl();

    /**
     * This function returns the content type returned by the server
     *
     * @return string Content type returned by the server
     *
     * @access public
     */
    public function getContentType();

    /**
     * This function returns the content type options returned by the server
     *
     * @return string Content type options returned by the server
     *
     * @access public
     */
    public function getContentTypeOptions();

    /**
     * This function returns the Cookies
     *
     * @return array Cookies
     *
     * @access public
     */
    public function getCookies();

    /**
     * This function returns the length of the returned data
     *
     * @return integer Length of returned data
     *
     * @access public
     */
    public function getContentLength();

    /**
     * This function returns the web server commands
     *
     * @return array Containing the Web Server commands.
     *
     * @access public
     */
    public function getAllow();

    /**
     * This function returns the raw data received from the server
     *
     * @return string The raw data received from the server
     *
     * @access public
     */
    public function getRawData();

    /**
     * This function returns the processed data received from the server
     *
     * @return array The processed data received from the server
     *
     * @access public
     */
    public function getProcessedData();
}