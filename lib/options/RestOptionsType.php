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

namespace g7mzr\restclient\options;

/**
 * RestOptionsType Class
 *
 * RestOptionsType Class is used to define the array keys for RestOptions
 *
 * @codeCoverageIgnore
 *
 */
class RestOptionsType
{
    const REST_BASE_URL = "restbaseurl";
    const REST_PROXY_SERVER = "restproxyserver";
    const REST_PROXY_PORT = "restproxyport";
    const REST_USER_AGENT = "restuseragent";
    const REST_COOKIE_FILE = "restcookiefile";





    /**
     * RestOptionsType Class Constructor
     *
     * Sets up Headers Class
     *
     * @access private
     */
    private function __construct()
    {
    }
}
