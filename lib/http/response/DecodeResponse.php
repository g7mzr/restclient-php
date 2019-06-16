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

namespace g7mzr\restclient\http\response;

use \g7mzr\restclient\exception\RestException;
use \g7mzr\restclient\RestDecodeResponse;

/**
 * Response Class
 *
 * Response Class processes the headers and data received from the web server RestFULL
 * API.
 *
 */
class DecodeResponse implements RestDecodeResponse
{
    /**
     * Property: httpresponsecode
     * @var string
     * @access private
     */
    private $httpresponsecode = "";

    /**
     * Property: contentType
     * @var string
     * @access private
     */
    private $contentType = "";

    /**
     * Property: contentLength
     * @var integer
     * @access private
     */
    private $contentLength = 0;

    /**
     * Property: allow
     * @var array
     * @access private
     */
    private $allow = array();

    /**
     * Property: rawData
     * @var string
     * @access private
     */
    private $rawData = "";

    /**
     * property processedData
     * @var array
     * @access private
     */
    private $processedData = array();

    /**
     * Database Manager Class Constructor
     *
     * Sets up the Database Manager Class
     *
     * @param array  $curlinfo The cURL information regarding the last transfer.
     * @param string $response The data returned from the remote sever.
     *
     * @throws RestException If data is not parsed correctly.
     *
     * @access public
     */
    public function __construct(array $curlinfo, string $response)
    {
        // Parse the headers
        $headerResult = $this->parseheaders($curlinfo);
        if ($headerResult === false) {
            throw new RestException('Failed to parse cURL Info', 1);
        }

        // Parse the data
        if ($response != "") {
            $dataresult = $this->parsedata($response);
            if ($dataresult === false) {
                throw new RestException('Failed to parse data', 1);
            }
        }
    }

    /**
     * Parse Response Headers
     *
     * This function processes the web server response headers
     *
     * @param array $curlinfo The cURL information regarding the last transfer.
     *
     * @return boolean True if the responses parsed correctly
     *
     * @access private
     */
    private function parseheaders(array $curlinfo)
    {
        $parseOk = true;

        if (array_key_exists("http_code", $curlinfo)) {
            $this->httpresponsecode = $curlinfo["http_code"];
        } else {
            $parseOk = false;
        }
        if (array_key_exists("content_type", $curlinfo)) {
            $this->contentType = $curlinfo["content_type"];
        }

        if (array_key_exists("download_content_length", $curlinfo)) {
            $this->contentLength = $curlinfo["download_content_length"];
        } else {
            $parseOk = false;
        }

        if (array_key_exists("allow", $curlinfo)) {
            $this->allow = explode(", ", $curlinfo["allow"]);
        }

        return $parseOk;
    }


    /**
     * Parse Response Data
     *
     * This function processes the data returned by the web server
     *
     * @param string $response The data returned from the remote sever.
     *
     * @return boolean True if the responses parsed correctly
     *
     * @access private
     */
    private function parsedata(string $response)
    {
        $parseOk = true;
        $this->rawData = trim($response);
        if ($this->contentType == "application/json") {
            $processedData = json_decode($response, true);
            if ($processedData !== null) {
                $this->processedData = $processedData;
            } else {
                 $parseOk = false;
            }
        } else {
            $parseOk = false;
        }
        return $parseOk;
    }

    /**
     * Get the HTTP response including error status.
     *
     * This function returns the HTTP response code as a string
     *
     * @return string The http response code
     *
     * @access public
     */
    public function getHTTPResponseCode()
    {
        return $this->httpresponsecode;
    }

    /**
     * Get the HTTP response message
     *
     * This function returns a more descriptive message corresponding to http
     * response code retrieved by getHTTPResonseCode()
     *
     * @return string Descriptive message corresponding to the response code.
     *
     * @access public
     */
    public function getHTTPResponseMessage()
    {
        $http_codes = parse_ini_file(__DIR__ . "/httpResponseCodes.ini");
        if (array_key_exists($this->httpresponsecode, $http_codes)) {
            return $http_codes[$this->httpresponsecode];
        } else {
            return sprintf("HTTP Response code %s not found", $this->httpresponsecode);
        }
    }

    /**
     * This function returns the content type returned by the server
     *
     * @return string Content type returned by the server
     *
     * @access public
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * This function returns the length of the returned data
     *
     * @return integer Length of returned data
     *
     * @access public
     */
    public function getContentLength()
    {
        return $this->contentLength;
    }

    /**
     * This function returns the options
     *
     * @return array Containing the Web Server Options.
     *
     * @access public
     */
    public function getAllow()
    {
        return $this->allow;
    }

    /**
     * This function returns the raw data received from the server
     *
     * @return string The raw data received from the server
     *
     * @access public
     */
    public function getRawData()
    {
        return $this->rawData;
    }
    /**
     * This function returns the processed data received from the server
     *
     * @return array The processed data received from the server
     *
     * @access public
     */
    public function getProcessedData()
    {
        return $this->processedData;
    }
}
