<?php
/**
 * This file is part of RESTCLIENT.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package restclient-php
 * @subpackage common
 * @author   Sandy McNeil <g7mzrdev@gmail.com>
 * @copyright (c) 2019, Sandy McNeil
 * @license https://github.com/g7mzr/restclient-php/blob/master/LICENSE GNU General Public License v3.0
 *
 */

namespace g7mzr\restclient;

/**
 * RESTCLIENT Error Class
 *
 * This class implements an error object for RESTCLIENT
 */
interface RestError
{
    /**
     * This function returns the error message
     *
     * @return string Return the error message.
     *
     * @access public
     */
    public function getMessage();

    /**
     * This function returns the error code
     *
     * @return integer The error code.
     *
     * @access public
     */
    public function getCode();
}
