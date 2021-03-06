<?php
/**
 * This file is part of  RESTCLIENT.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package restclient-php
 * @subpackage API Test
 * @author   Sandy McNeil <g7mzrdev@gmail.com>
 * @copyright (c) 2019, Sandy McNeil
 * @license https://github.com/g7mzr/restclient-php/blob/master/LICENSE GNU General Public License v3.0
 *
 */

require_once 'restapi.class.php';

/**
 * Sent the HTTP Headers to the client.
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("X-Content-Type-Options: nosniff");
header("Content-Type: application/json");
setcookie("apitest", "testdata");

/**
 * This section implements the API.  Certain Changes have been made to allow testing
 * of restclient.
 */

$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);
if ($method == 'POST' && filter_has_var(INPUT_SERVER, 'HTTP_X_HTTP_METHOD')) {
    $options = array(
        'options' => array(
            'regexp' => "/^([A-Z']{3,10})$/"
        )
    );
    $method = filter_input(
        INPUT_SERVER,
        'HTTP_X_HTTP_METHOD',
        FILTER_VALIDATE_REGEXP,
        $options
    );
}

// Get the request from the $_SERVER Super Global Array and remove "request="
$request = str_replace(
    'request=',
    '',
    Filter_input(INPUT_SERVER, 'QUERY_STRING', FILTER_SANITIZE_URL)
);

// Get the body content type
if (filter_has_var(INPUT_SERVER, "CONTENT_TYPE")) {
    $contentType = filter_input(
        INPUT_SERVER,
        "CONTENT_TYPE",
        FILTER_SANITIZE_STRING
    );
} else {
    $contentType = '';
}

if (filter_has_var(INPUT_SERVER, 'HTTP_ACCEPT')) {
    $acceptType = filter_input(
        INPUT_SERVER,
        'HTTP_ACCEPT',
        FILTER_SANITIZE_STRING
    );
} else {
    $acceptType = '';
}

// Collect the request data
$post = filter_input_array(INPUT_POST);
$get = filter_input_array(INPUT_GET);
$file = file_get_contents("php://input");

try {
    // Create the RESTful API class
    $api = new \g7mzr\restclient\webserver\RESTapi(
        $request,
        $method,
        $post,
        $get,
        $file,
        $contentType,
        $acceptType
    );

    // Process the data stored in the API class and get the results
    $result = $api->processAPI();

    // Publish the results to the client starting with the header then the data.
    header($result['header']);

    // Send the options header if it exists
    if (key_exists('options', $result)) {
        header($result['options']);
    }

    // Send the Content-Length and Data if any exists.
    // or send only the Content-Length for a HEAD request
    // or send a zero Content-Length if their is no data ie OPTIONS request or error
    if (key_exists('data', $result)) {
        $datasize = strlen($result['data']);
        header('Content-Length: ' . $datasize);
        echo $result['data'];
    } elseif (key_exists('head', $result)) {
         header('Content-Length: ' . $result['head']);
    } else {
        header('Content-Length: 0');
    }
} catch (Throwable $e) {
    // There was an exception.  Send out the error to the client
    if ($e->getCode() == 405) {
        header("HTTP/1.1 405 Method Not Allowed");
    } elseif ($e->getCode() == 400) {
        header("HTTP/1.1 400 Bad Request");
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
    $msg = json_encode(array('Errormsg' => $e->getMessage()));
    $datasize = strlen($msg);
    header('Content-Length: ' . $datasize);
    echo $msg;
}
