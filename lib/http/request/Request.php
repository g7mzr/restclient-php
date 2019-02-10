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

namespace g7mzr\restclient\http\request;

use \g7mzr\restclient\RestRequest;

/**
 * RestRequest Class
 *
 * RestRequest Class is used to set up the HTTP request for Curl.
 *
 */
class Request implements RestRequest
{
    /**
     * Property: options
     * @var array
     * @access private
     */
    private $options;

    /**
     * Property: method
     * @var string
     * @access private
     */
    private $httpmethod;

    /**
     * Request Class Constructor
     *
     * Sets up Request Class
     *
     * @param string $httpmethod The method the resource has been set up for.
     *
     * @access public
     */
    public function __construct(string $httpmethod = "get")
    {
        $this->options = array();
        $this->httpmethod = $httpmethod;
    }

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
    public function setEndPoint(string $endpoint)
    {
        $this->set(RestRequestType::REST_ENDPOINT, $endpoint);
        return $this;
    }

    /**
     * getEndPoint Method
     *
     * This method returns the EndPoint of the API request.
     *
     * @return string Endpoint of the API Request. Default = Empty string.
     *
     * @access public
     */
    public function getEndPoint()
    {
        return $this->get(RestRequestType::REST_ENDPOINT, '');
    }

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
    public function setAcceptHeader(string $accept)
    {
        $this->set(RestRequestType::REST_ACCEPT_HEADER, $accept);
        return $this;
    }

    /**
     * getAcceptHeader Method
     *
     * This method returns the HTTP Accept Header
     *
     * @return string HTTP Accept Header.  Default = Empty string
     *
     * @access public
     */
    public function getAcceptHeader()
    {
        return $this->get(RestRequestType::REST_ACCEPT_HEADER, 'application/json');
    }


    /**
     * setPostData
     *
     * Set the data to be posted to the api.  Data is passed to the function in the
     * form of an array containing a number of $key => $value pairs
     *
     * @param array $postdata  The data to be sent to the rest API
     *
     * @return Request Pointer to the RestRequest Instance being accessed
     *
     * @access public
     */
    public function setURLEncodedData(array $postdata)
    {
        $datastring = "";
        $arraylength = count($postdata);
        $currentelement = 1;
        foreach ($postdata as $key => $value) {
            $datastring .= $key . "=" . $value;
            if ($currentelement < $arraylength) {
                $datastring .= "&";
            }
            $currentelement = $currentelement + 1;
        }
        $this->set(RestRequestType::REST_URLENCODED_DATA, $datastring);
    }

    /**
     * getPostData Method
     *
     * This method returns a string containing the url encoded post data.
     *
     * @return string URL Encoded Post Data
     *
     * @access public
     */
    public function getURLEncodedData()
    {
        return $this->get(RestRequestType::REST_URLENCODED_DATA, "");
    }

    /**
     * setJSONEncodedData
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
    public function setJSONEncodedData(array $postdata)
    {
        $datastring = json_encode($postdata);
        $this->set(RestRequestType::REST_JSONENCODED_DATA, $datastring);
    }

    /**
     * getJSONEncodedData Method
     *
     * This method returns a string containing JSON encoded post data.
     *
     * @return string URL Encoded Post Data
     *
     * @access public
     */
    public function getJSONEncodedData()
    {
        return $this->get(RestRequestType::REST_JSONENCODED_DATA, "");
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
