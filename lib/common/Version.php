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

namespace g7mzr\restclient\common;

/**
 * Version Class
 *
 * Version Class is used to define the Default Name and Version for RestFull Client.  It
 * also defines the the default UserAgent
 *
 * @codeCoverageIgnore
 *
 */
class Version
{
    const NAME = "PHP RESTFull API Client";
    const VERSION = "0.1.0";

    const USERAGENT = self::NAME . "/" . self::VERSION . " " . PHP_OS . " PHP:" . PHP_VERSION;

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
