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
     * Property: httpresponse
     * @var array
     * @access private
     */
    private $httpresponse = array();

    /**
     * Property: Date
     * @var integer
     * @access private
    */
    private $date = 0;

    /**
     * Property: server
     * @var string
     * @access private
     */
    private $server = "";

    /**
     * Property: contentType
     * @var string
     * @access private
     */
    private $contentType = "";

    /**
     * Property: contentTypeOptions
     * @var string
     * @access private
     */
    private $contentTypeOptions = "";

    /**
     * Property: contentLength
     * @var integer
     * @access private
     */
    private $contentLength = 0;

    /**
     * Property: xpowered
     * @var string
     * @access private
     */
    private $xpowered = "";

    /**
     * Property: accessControl
     * @var array
     * @access private
     */
    private $accessControl = array();

    /**
     * Property: allow
     * @var array
     * @access private
     */
    private $allow = array();

    /**
     * Property: cookies
     * @var array
     * @access private
     */
    private $cookies = array();

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
     * @param string $response The response from the RestFull API.
     *
     * @throws RestException If data is not parsed correctly.
     *
     * @access public
     */
    public function __construct(string $response)
    {
        // Convert the response string to an array
        $responsearray = explode("\r\n", $response);

        // Move the http headers to their own array
        $headerarray = array();
        $counter = 0;
        while (($counter < sizeof($responsearray)) and ($responsearray[$counter] != '')) {
            $headerarray[] = $responsearray[$counter];
            $counter++;
        }

        //  Move the data to its own array
        $counter++;
        $dataarray = array();
        while (($counter < sizeof($responsearray)) and ($responsearray[$counter] != '')) {
            $dataarray[] = $responsearray[$counter];
            $counter++;
        }

        // Parse the headers
        $this->parseheaders($headerarray);

        // Parse the data
        if (count($dataarray) > 0) {
            $dataresult = $this->parsedata($dataarray);
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
     * @param array $responsearray The response from the RestFull API.
     *
     * @return boolean True if the responses parsed correctly
     *
     * @access private
     */
    private function parseheaders(array $responsearray)
    {
        $parseOk = true;
        foreach ($responsearray as $value) {
            if (strpos($value, "HTTP") !== false) {
                $this->httpresponse = explode(" ", $value, 3);
            }

            if (strpos($value, "Date:") !== false) {
                list($name, $time) = explode(": ", $value, 2);
                $this->date = strtotime($time);
            }

            if (strpos($value, "Server:") !== false) {
                list($name, $data) = explode(": ", $value, 2);
                $this->server = $data;
            }

            if (strpos($value, "X-Powered-By:") !== false) {
                list($name, $data) = explode(": ", $value, 2);
                $this->xpowered = $data;
            }

            if (strpos($value, "Access-Control-Allow-Origin:") !== false) {
                list($name, $data) = explode(": ", $value, 2);
                $this->accessControl['origin'] = $data;
            }

            if (strpos($value, "Access-Control-Allow-Methods:") !== false) {
                list($name, $data) = explode(": ", $value, 2);
                $this->accessControl['methods'] = $data;
            }

            if (strpos($value, "X-Content-Type-Options:") !== false) {
                list($name, $data) = explode(": ", $value, 2);
                $this->contentTypeOptions = $data;
            }

            if (strpos($value, "Set-Cookie:") !== false) {
                list($name, $data) = explode(": ", $value, 2);
                $this->cookies[] = $data;
            }

            if (strpos($value, "Content-Length:") !== false) {
                list($name, $data) = explode(": ", $value, 2);
                $this->contentLength = $data;
            }

            if (strpos($value, "Content-Type:") !== false) {
                list($name, $data) = explode(": ", $value, 2);
                $this->contentType = $data;
            }

            if (strpos($value, "Allow:") !== false) {
                list($name, $data) = explode(": ", $value, 2);
                $this->allow = explode(", ", $data);
            }
        }
        return $parseOk;
    }


    /**
     * Parse Response Data
     *
     * This function processes the data returned by the web server
     *
     * @param array $dataarray The response from the RestFull API.
     *
     * @return boolean True if the responses parsed correctly
     *
     * @access private
     */
    private function parsedata(array $dataarray)
    {
        $parseOk = true;
        $datastr = "";
        foreach ($dataarray as $value) {
            $datastr .= $value;
        }
        if ($this->contentType == "application/json") {
            $processedData = json_decode($datastr, true);
            if ($processedData !== null) {
                $this->rawData = trim($datastr);
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
     * This function returns the HTTP response as an array.  The first element contains
     * the HTTP version.  The second element contains the status code and the third the
     * status message.
     *
     * @return array The http response
     *
     * @access public
     */
    public function getHTTPResponce()
    {
        return $this->httpresponse;
    }

    /**
     * This function returns the date and time the response was received from the server
     *
     * @return integer The date and time the response was received from the server
     *
     * @access public
     */
    public function getHTTPDate()
    {
        return $this->date;
    }

    /**
     * This function returns the server description
     *
     * @return string Server description
     *
     * @access public
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * This function returns the X-Powered-By description
     *
     * @return string X-Powered-By description
     *
     * @access public
     */
    public function getXPoweredBy()
    {
        return $this->xpowered;
    }

    /**
     * This function returns the Access-Control Data Array
     *
     * @return array Access-Control data
     *
     * @access public
     */
    public function getAccessControl()
    {
        return $this->accessControl;
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
     * This function returns the content type options returned by the server
     *
     * @return string Content type options returned by the server
     *
     * @access public
     */
    public function getContentTypeOptions()
    {
        return $this->contentTypeOptions;
    }


    /**
     * This function returns the Cookies
     *
     * @return array Cookies
     *
     * @access public
     */
    public function getCookies()
    {
        return $this->cookies;
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
