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
 * RestRequest Class
 *
 * RestRequest Class is used to set up the HTTP request for Curl.
 *
 */
interface RestRequest
{
    /**
     * setEndPoint Method
     *
     * This method sets the endpoint for the api request
     *
     * @param string $endpoint The Endpoint of the API Request.
     *
     * @return Request Pointer to the RestRequest Instance being accessed
     *
     * @access public
     */
    public function setEndPoint(string $endpoint);

    /**
     * getEndPoint Method
     *
     * This method returns the EndPoint of the API request.
     *
     * @return string Endpoint of the API Request. Default = Empty string
     *
     * @access public
     */
    public function getEndPoint();

    /**
     * setAcceptHeader
     *
     * Set the Accept Header.
     *
     * @param string $accept The comma delimited HTTP Accept header.
     *
     * @return Request Pointer to the RestRequest Instance being accessed
     *
     * @access public
     */
    public function setAcceptHeader(string $accept);

    /**
     * getAcceptHeader Method
     *
     * This method returns the HTTP Accept Header
     *
     * @return string HTTP Accept Header.  Default = application/json
     *
     * @access public
     */
    public function getAcceptHeader();

    /**
     * setURLEncodedData
     *
     * Set the data to be posted to the api.  Data is passed to the function in the
     * form of an array containing a number of $key => $value pairs and will encode
     * using URL data format
     *
     * @param array $postdata  The data to be sent to the rest API
     *
     * @return Request Pointer to the RestRequest Instance being accessed
     *
     * @access public
     */
    public function setURLEncodedData(array $postdata);

    /**
     * getURLEncodedData Method
     *
     * This method returns a string containing the url encoded post data.
     *
     * @return string URL Encoded Post Data
     *
     * @access public
     */
    public function getURLEncodedData();

    /**
     * setUJSONEncodedData
     *
     * Set the data to be posted to the api.  Data is passed to the function in the
     * form of an array containing a number of $key => $value pairs and will encode
     * using JSON data format
     *
     * @param array $postdata  The data to be sent to the rest API
     *
     * @return Request Pointer to the RestRequest Instance being accessed
     *
     * @access public
     */
    public function setJSONEncodedData(array $postdata);

    /**
     * getJSONEncodedData Method
     *
     * This method returns a string containing JSON encoded post data.
     *
     * @return string URL Encoded Post Data
     *
     * @access public
     */
    public function getJSONEncodedData();
}
