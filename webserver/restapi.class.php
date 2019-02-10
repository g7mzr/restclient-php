<?php
/**
 * This file is part of  RESTCLIENT.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package restclient-php
 * @subpackage API_Test
 * @author   Sandy McNeil <g7mzrdev@gmail.com>
 * @copyright (c) 2019, Sandy McNeil
 * @license https://github.com/g7mzr/restclient-php/blob/master/LICENSE GNU General Public License v3.0
 *
 */

namespace g7mzr\restclient\webserver;

/**
 * RestClient
 *
 * This class is used to enable testing of RestClient.  It is one of three files that
 * need to be installed on an Apache Web Server.
 **/

class RESTapi
{
    /**
     * Property: method
     * The HTTP method this request was made in, either GET, POST, PUT or DELETE
     *
     * @var    string
     * @access protected
     */
    protected $method = '';

    /**
     * Property: endpoint
     * The Model requested in the URI. eg: /files
     *
     * @var    string
     * @access protected
     */
    protected $endpoint = '';

    /**
     * Property: args
     * Any additional URI components after the endpoint and verb have been removed,
     * in our case, an integer ID for the resource.
     * eg: /<endpoint>/<verb>/<arg0>/<arg1> or /<endpoint>/<arg0>
     *
     * @var    array
     * @access protected
     */
    protected $args = array();

    /**
     * Property: file
     * Stores the input of the PUT request
     *
     * @var    string
     * @access protected
     */
    protected $file = null;

    /**
     * Property: requestdata
     * The data the end point needs to act on in an array format.  It can either
     * be for the Request Parameters or a JSOn file
     *
     * @var    array
     * @access protected
     */
    protected $requestdata= array();

    /**
     * Property: contenttype
     * The format of the data sent by the client.
     *
     * @var    string
     * @access protected
     */
    protected $contenttype = "";

    /**
     * Property: accepttype
     * The format of the returned data acceptable to the client.
     *
     * @var    string
     * @access protected
     */
    protected $accepttype = "";

    /**
     * Constructor
     *
     * @param string $args        Client request string /<endpoint>/<arg0>/<arg1>
     * @param string $method      The HTTP method used to call the api
     * @param array  $post        The contents of the $_POST super global array
     * @param array  $get         The contents of the $_GET super global array
     * @param string $file        The contents of php://input
     * @param string $contenttype HTTP body content type i.e. application/json
     * @param string $accepttype  HTTP body content type that client can accept
     *
     * @access public
     */
    public function __construct(
        $args,
        $method,
        $post,
        $get,
        $file,
        $contenttype,
        $accepttype    ) {

        $this->args = explode('/', rtrim($args, '/'));
        $this->endpoint = array_shift($this->args);
        $this->method = $method;

        switch ($this->method) {
            case 'POST':
                $request = $this->cleanInputs($post);

                // Convert $file from JSON to an PHP array
                $filearray =json_decode($file, true);
                break;
            case 'GET':
            case 'DELETE':
            case 'HEAD':
            case 'OPTIONS':
                $request = $this->args;
                break;
            case 'PATCH':
            case 'PUT':
                $request = $this->cleanInputs($post);

                // Convert $file from JSON to an PHP array
                $filearray = json_decode($file, true);
                break;
            default:
                throw new \Exception(
                    'Method Not Allowed: ' . $this->method,
                    405
                );
        }

        // If there is no data in file make it an empty array
        if ($file == null) {
            $filearray = array();
        }

        $this->contenttype = $contenttype;

        $this->accepttype = $accepttype;
    }

    /**
     * This function process the request by calling the selected endpoint.  If no
     * endpoint is found an error is returned.
     *
     * @return string The JSON encoded result of the API request.
     *
     * @access public
     */
    public function processAPI()
    {
        $result = array();

        $result["code"] = 200;

        $result['data'] = array(
            "endpoint" => $this->endpoint,
            "method" => $this->method,
            "args" => $this->args,
            "requestdata" => $this->requestdata,
            "contenttype" => $this->contenttype,
            "accepttype" => $this->accepttype
        );

        return $this->response($result);
    }

    /**
     * This function sends the HTTP response and encodes the data in JSON
     *
     * @param array   $data   The data to be json encoded and returned to the user
     * @param integer $status The status of the request
     *
     * @return string The JSON encoded result of the API request.
     *
     * @access private
     */
    private function response($data)
    {
        $status = $data['code'];
        $result = array();
        $result['header'] = "HTTP/1.1 " . $status . " " . $this->requestStatus($status);
        if (key_exists('data', $data)) {
            $result['data'] = json_encode($data['data']);
        }
        if (key_exists('options', $data)) {
            $result['options'] = "Allow: " . $data['options'];
        }
        if (key_exists('head', $data)) {
            $result['head'] = $data['head'];
        }
        return $result;
    }

    /**
     * This function processes the input data and returns it in an array
     *
     * @param mixed $data The data to be processed
     *
     * @return array An Array containing the request data from the client
     *
     * @access private
     */
    private function cleanInputs($data)
    {
        $clean_input = array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->cleanInputs($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }

    /**
     * This function translates error codes to error strings.
     *
     * @param integer $code The http status code of the request
     *
     * @return string containing the text version of the error code
     *
     * @access private
     */
    private function requestStatus($code)
    {
        $status = array(
            200 => 'OK',
            201 => 'Created',
            204 => 'No Content',
            400 => 'Bad Request',
            401 => 'Unauthorised',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            409 => 'Conflict',
            500 => 'Internal Server Error',
            501 => 'Not Implemented'
        );
        return ($status[$code])?$status[$code]:$status[500];
    }

    /**
     * This function processes the endpoint by calling the appropriate method which
     * is stored in the endpoint file as a function based on the method name
     *
     * @param string $method      HTTP method such as GET, DELETE, POST
     * @param array  $args        Additional URI components
     * @param array  $requestdata Contents of the GET or POST request
     *
     * @return array The result of the action undertaken by the API end point.
     *
     * @access private

    private function endpoint($method, $args, $requestdata)
    {
        // Process and save the $requestdata to the Class Variable
        // Remove the endpoint from the requestdata if it is there
        $path = explode('\\', __CLASS__);
        $endpoint = strtolower(array_pop($path));
        if (key_exists('request', $requestdata)) {
            if ($requestdata['request'] == $endpoint) {
                $localendpoint = array_shift($requestdata);
            }
        }

        $result = array('data' => $dataarr, 'options' => $optionstr, 'code' => 405);


        return $result;
    }

  */

}
