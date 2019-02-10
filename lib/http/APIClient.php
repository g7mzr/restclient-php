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

namespace g7mzr\restclient\http;

use g7mzr\restclient\RestAPIClient;
use g7mzr\restclient\http\request\Request;
use g7mzr\restclient\options\Options;
use g7mzr\restclient\http\response\DecodeResponse;

/**
 * RestAPIClient Class
 *
 * RestAPICLient Class is used to call PHP cURL and send or receive data from the Server
 *
 */
class APIClient implements RestAPIClient
{
    /**
     * property: httpresponse
     * @var string;
     * @access private
     */
    private $httpResponse = "";

    /**
     * property: responseError
     * @var array
     * @access private
     */
    private $responseError;

    /**
     * property: options
     * @var Options
     * @access private
     */
    private $options;

    /**
     * property: request
     * @var Request
     * @access private
     */
    private $request;

    /**
     * Property: headers
     * @var array
     * @access private
     */
    private $headers;

    /**
     * APIClient Class Constructor
     *
     * Sets up APIClient Class
     *
     * @param Options $options The RESTClient Configuration Options.
     *
     * @access public
     */
    public function __construct(Options $options)
    {
        $this->options = $options;
        $this->responseError = array();
        $this->headers = array();
    }

    /**
     * Destructor
     *
     * This function cleans up when the resource is destroyed
     *
     * @access public
     */
    public function __destruct()
    {
        // Delete the Cookies file as it is no longer needed.
        $cookiefilename = $this->options->getCookiefile();
        if ($cookiefilename != "") {
            if (file_exists($cookiefilename)) {
                unlink($cookiefilename);
            }
        }
    }

    /**
     * httpGet Method
     *
     * This method implements the HTTP GET Method
     *
     * @param Request $restrequest The HTTP Request Data for the GET Method.
     *
     * @return boolean True if the command executed correctly.  False otherwise
     *
     * @access public
     */
    public function httpGet(Request $restrequest)
    {
        $this->request = $restrequest;

        // Initalise the responseError Array
        $this->responseError = array();

        // Initalise the response string
        $this->httpResponse = "";

        // Initalise the headers array
        $this->headers = array();

        $ch = curl_init();
        if ($ch ===false) {
            $this->responseError['code'] = 1;
            $this->responseError['message'] = 'Unable to initalise cURL resource';
            return false;
        }
        $optionResult = $this->setCurlOptions($ch);
        if ($optionResult ===false) {
            $this->responseError['code'] = 2;
            $this->responseError['message'] = 'Unable to set cURL options';
            curl_close($ch);
            return false;
        }
        // Add the Headers to the curl resource
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $output = curl_exec($ch);

        if ($output === false) {
            $this->responseError['code'] = 3;
            $this->responseError['message'] = 'Error running cURL';
            curl_close($ch);
            return false;
        }
        curl_close($ch);
        $this->httpResponse = $output;
        return true;
    }


    /**
     * httpHead Method
     *
     * This method implements the HTTP HEAD Method
     *
     * @param RestRequest $restrequest The HTTP Request Data for the HEAD Method.
     *
     * @return boolean True if the command executed correctly.  False otherwise
     *
     * @access public
     */
    public function httpHead(Request $restrequest)
    {
        $this->request = $restrequest;

        // Initalise the responseError Array
        $this->responseError = array();

        // Initalise the response string
        $this->httpResponse = "";

        // Initalise the headers array
        $this->headers = array();

        $ch = curl_init();
        if ($ch ===false) {
            $this->responseError['code'] = 1;
            $this->responseError['message'] = 'Unable to initalise cURL resource';
            return false;
        }
        $optionResult = $this->setCurlOptions($ch);
        if ($optionResult ===false) {
            $this->responseError['code'] = 2;
            $this->responseError['message'] = 'Unable to set cURL options';
            curl_close($ch);
            return false;
        }

        // Set specific cURL Options for the HTTP HEAD methos
        curl_setopt($ch, CURLOPT_NOBODY, 1);

         // Add the Headers to the curl resource
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $output = curl_exec($ch);

        if ($output === false) {
            $this->responseError['code'] = 3;
            $this->responseError['message'] = 'Error running cURL';
            curl_close($ch);
            return false;
        }
        curl_close($ch);
        $this->httpResponse = $output;
        return true;
    }


    /**
     * httpOptions Method
     *
     * This method implements the HTTP OPTIONS Method
     *
     * @param RestRequest $restrequest The HTTP Request Data for the OPTIONS Method.
     *
     * @return boolean True if the command executed correctly.  False otherwise
     *
     * @access public
     */
    public function httpOptions(Request $restrequest)
    {
        $this->request = $restrequest;

        // Initalise the responseError Array
        $this->responseError = array();

        // Initalise the response string
        $this->httpResponse = "";

        // Initalise the headers array
        $this->headers = array();

        $ch = curl_init();
        if ($ch ===false) {
            $this->responseError['code'] = 1;
            $this->responseError['message'] = 'Unable to initalise cURL resource';
            return false;
        }
        $optionResult = $this->setCurlOptions($ch);
        if ($optionResult ===false) {
            $this->responseError['code'] = 2;
            $this->responseError['message'] = 'Unable to set cURL options';
            curl_close($ch);
            return false;
        }

        // Set specific cURL Options for the HTTP OPTIONS method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "OPTIONS");

        // Add the Headers to the curl resource
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $output = curl_exec($ch);

        if ($output === false) {
            $this->responseError['code'] = 3;
            $this->responseError['message'] = 'Error running cURL';
            curl_close($ch);
            return false;
        }
        curl_close($ch);
        $this->httpResponse = $output;
        return true;
    }


    /**
     * httpPost Method
     *
     * This method implements the HTTP POST Method
     *
     * @param RestRequest $restrequest The HTTP Request Data for the POST Method.
     *
     * @return boolean True if the command executed correctly.  False otherwise
     *
     * @access public
     */
    public function httpPost(Request $restrequest)
    {
        $this->request = $restrequest;

        // Initalise the responseError Array
        $this->responseError = array();

        // Initalise the response string
        $this->httpResponse = "";

        // Initalise the headers array
        $this->headers = array();

        $ch = curl_init();
        if ($ch ===false) {
            $this->responseError['code'] = 1;
            $this->responseError['message'] = 'Unable to initalise cURL resource';
            return false;
        }
        $optionResult = $this->setCurlOptions($ch);
        if ($optionResult ===false) {
            $this->responseError['code'] = 2;
            $this->responseError['message'] = 'Unable to set cURL options';
            curl_close($ch);
            return false;
        }

        // Set specific cURL Options for the HTTP POST method
        if($this->request->getURLEncodedData() != "") {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->request->getURLEncodedData());
            $this->addHeader("content-type: application/x-www-form-urlencoded");
        } elseif ($this->request->getJSONEncodedData() != "") {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->request->getJSONEncodedData());
            $this->addHeader("content-type: application/json");
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            $this->addHeader("content-type: application/x-www-form-urlencoded");

        }

        // Add the Headers to the curl resource
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $output = curl_exec($ch);

        if ($output === false) {
            $this->responseError['code'] = 3;
            $this->responseError['message'] = 'Error running cURL';
            curl_close($ch);
            return false;
        }
        curl_close($ch);
        $this->httpResponse = $output;
        return true;
    }

    /**
     * httpPut Method
     *
     * This method implements the HTTP PUT Method
     *
     * @param RestRequest $restrequest The HTTP Request Data for the PUT Method.
     *
     * @return boolean True if the command executed correctly.  False otherwise
     *
     * @access public
     */
    public function httpPut(Request $restrequest)
    {
        $this->request = $restrequest;

        // Initalise the responseError Array
        $this->responseError = array();

        // Initalise the response string
        $this->httpResponse = "";

        // Initalise the headers array
        $this->headers = array();

        $ch = curl_init();
        if ($ch ===false) {
            $this->responseError['code'] = 1;
            $this->responseError['message'] = 'Unable to initalise cURL resource';
            return false;
        }
        $optionResult = $this->setCurlOptions($ch);
        if ($optionResult ===false) {
            $this->responseError['code'] = 2;
            $this->responseError['message'] = 'Unable to set cURL options';
            curl_close($ch);
            return false;
        }

        // Set specific cURL Options for the HTTP POST method
        if($this->request->getURLEncodedData() != "") {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->request->getURLEncodedData());
            $this->addHeader("content-type: application/x-www-form-urlencoded");
        } elseif ($this->request->getJSONEncodedData() != "") {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->request->getJSONEncodedData());
            $this->addHeader("content-type: application/json");
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, "");
            $this->addHeader("content-type: application/x-www-form-urlencoded");

        }

        // Set specific cURL Options for the HTTP PUT method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

        // Add the Headers to the curl resource
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $output = curl_exec($ch);

        if ($output === false) {
            $this->responseError['code'] = 3;
            $this->responseError['message'] = 'Error running cURL';
            curl_close($ch);
            return false;
        }
        curl_close($ch);
        $this->httpResponse = $output;
        return true;
    }
















    /**
     * getResponce Method
     *
     * This method returns a DecodeResponse Object
     *
     * @return mixed DecodeResponse  or false if an error has occurred.
     *
     * @access public
     */
    public function getResponse()
    {
        if ($this->httpResponse != "") {
            return new DecodeResponse($this->httpResponse);
        } else {
            return false;
        }
    }

    /**
     * getError
     *
     * Returns the APIClient Error in the form of an array with the following keys:
     * code - The error code
     * Message - The error Message
     *
     * @return array Containing the error Message and code.
     *
     * @access public
     */
    public function getError()
    {
        return $this->responseError;
    }

    /**
     * Process cURL Options
     *
     * This method processes the options passed to the class when it is initalised and
     * the request data passed in the HTTP method function uses them to set cURL options.
     *
     * @param resource $ch CURL Handle.
     *
     * @return boolean True if Options processed.
     *
     * @access private
     */
    private function setCurlOptions($ch)
    {
        // Set Generic Options First
        //return the transfer as a string and include the headers
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        // Set the User Agent
        if ($this->options->getUserAgent() != "") {
            curl_setopt($ch, CURLOPT_USERAGENT, $this->options->getUserAgent());
        }

        // Set the URL
        if (($this->options->getBaseURL() != "") and ($this->request->getEndPoint() != "")) {
            $url = $this->options->getBaseURL() . $this->request->getEndPoint();
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            return false;
        }

        // Set the headers
        $headers = array();

        // Check that the Accept Header exists and if it does add it to the array
        if ($this->request->getAcceptHeader() != "") {
            $this->addHeader("Accept: " . $this->request->getAcceptHeader());
        } else {
            return false;
        }

        // Set the Proxy if it is used
        if ($this->options->getProxyServer() != "") {
            curl_setopt($ch, CURLOPT_PROXY, $this->options->getProxyServer());
        }
        if ($this->options->getProxyServerPort() != "") {
            curl_setopt($ch, CURLOPT_PROXYPORT, $this->options->getProxyServerPort());
        }

        if ($this->options->getCookiefile() != "") {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->options->getCookiefile());
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->options->getCookiefile());
        }

        return true;
    }

    /**
     * addHeader
     *
     * This function adds headers to the headers array
     *
     * @param string $header The header to be added to the array
     *
     * @return boolean true
     *
     * @access private
     */
    private function addHeader(string $header)
    {
        $this->headers[] = $header;
        return true;
    }
}
