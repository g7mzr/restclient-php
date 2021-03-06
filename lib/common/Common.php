<?php
/**
 * This file is part of  RESTCLIENT.
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

namespace g7mzr\restclient\common;

use g7mzr\restclient\RestCommon;

/**
 * The list below contains the error codes for the RestFULL API
 *
 * If you add a code here make sure you add it to the textual version
 * in Common::errorMessage()
 */

/**
 * No Error
 */
define('API_OK', true);

/**
 * Unspecified error
 */
define('API_ERROR', -1);

/**
 * Unable to connect to the Remote Server
 */
define('API_CANNOT_CONNECT', -2);

/**
 * Requested Function Not Implemented
 */
define('API_NOT_IMPLEMENTED', -3);

/**
 * Unable to log in to remote server
 */
define('API_LOGIN_FAILURE', -3);

/**
 * RESTCLIENT Common Code Class
 *
 * This module provide code which is common to all modules in RESTCLIENT
 */
class Common implements RestCommon
{

    /**
     * This method is used to check if the supplied variable is an restclient error.
     *
     * This method is used to check if the variable $data is of type
     * \g7mzr\restclient\common\Error which is the restclient error object.  It will
     * return true if $data is of type \g7mzr\restclient\common\Error.
     *
     * @param mixed $data The value to test.
     *
     * @return boolean True if $data is an error object.
     *
     * @access public
     */
    public static function isError($data)
    {
        return is_a($data, '\g7mzr\restclient\common\Error', false);
    }

    /**
     * This method is used to create an error object of type \g7mzr\restclient\common\Error.
     *
     * This function is used to create an object of type \g7mzr\restclient\common\Error which
     * is a error object for the restclient
     *
     * @param string  $message A text message or error object.
     * @param integer $code    The error code.
     *
     * @return \g7mzr\restclient\common\Error A restclient Error object.
     *
     * @access public
     */
    public static function raiseError(string $message = null, int $code = null)
    {
        return new \g7mzr\restclient\common\Error($message, $code);
    }

    /**
     * Return a textual error message for a API error code
     *
     * @param integer $value Error code.
     *
     * @return string error message or Unknown Error if the code is not recognised
     *
     * @access public
     */
    public function errorMessage(int $value)
    {
        $errorMessages = array(
            API_OK                => "No Error",
            API_ERROR             => "Unknown Error",
            API_CANNOT_CONNECT    => "Unable to connect to the remote server",
            API_NOT_IMPLEMENTED   => "Function not implemented",
            API_LOGIN_FAILURE     => "Invalid username and password combination"
        );
        return isset($errorMessages[$value]) ?
           $errorMessages[$value] : $errorMessages[API_ERROR];
    }
}
