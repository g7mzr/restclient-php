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

/**
 * RestRequestType Class
 *
 * RestRequestType Class is used to define the array keys for RestRequest
 *
 * @codeCoverageIgnore
 *
 */
class RestRequestType
{
    const REST_ENDPOINT = "restendpoint";
    const REST_ACCEPT_HEADER = "reastacceptheader";
    const REST_URLENCODED_DATA = "resturlencodeddata";
    const REST_JSONENCODED_DATA = "restjsonencodeddata";

    /**
     * RestRequestType Class Constructor
     *
     * Sets up Headers Class
     *
     * @access private
     */
    private function __construct()
    {
    }
}
