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
interface RestAPIClient
{
    /**
     * httpGet Method
     *
     * This method implements the HTTP GET Method
     *
     * @param RestRequest $restrequest The HTTP Request Data for the GET Method.
     *
     * @return boolean True if the command executed correctly. restclient error otherwise
     *
     * @access public
     */
    public function httpGet(Request $restrequest);

    /**
     * httpHead Method
     *
     * This method implements the HTTP HEAD Method
     *
     * @param RestRequest $restrequest The HTTP Request Data for the HEAD Method.
     *
     * @return boolean True if the command executed correctly. restclient error otherwise
     *
     * @access public
     */
    public function httpHead(Request $restrequest);

    /**
     * httpOptions Method
     *
     * This method implements the HTTP OPTIONS Method
     *
     * @param RestRequest $restrequest The HTTP Request Data for the OPTIONS Method.
     *
     * @return boolean True if the command executed correctly.  restclient error otherwise
     *
     * @access public
     */
    public function httpOptions(Request $restrequest);


    /**
     * httpPut Method
     *
     * This method implements the HTTP PUT Method
     *
     * @param RestRequest $restrequest The HTTP Request Data for the PUT Method.
     *
     * @return boolean True if the command executed correctly.  restclient error otherwise
     *
     * @access public
     */
    public function httpPut(Request $restrequest);


    /**
     * httpPost Method
     *
     * This method implements the HTTP POST Method
     *
     * @param RestRequest $restrequest The HTTP Request Data for the POST Method.
     *
     * @return boolean True if the command executed correctly.  restclient error otherwise
     *
     * @access public
     */
    public function httpPost(Request $restrequest);

    /**
     * httpDelete Method
     *
     * This method implements the HTTP DELETE Method
     *
     * @param RestRequest $restrequest The HTTP Request Data for the DELETE Method.
     *
     * @return boolean True if the command executed correctly.  restclient error otherwise
     *
     * @access public
     */
    public function httpDelete(Request $restrequest);



    /**
     * getResponce Method
     *
     * This method returns a DecodeResponse Object
     *
     * @return DecodeResponse  The headers and data returned by the web server
     *
     * @access public
     */
    public function getResponse();
}
