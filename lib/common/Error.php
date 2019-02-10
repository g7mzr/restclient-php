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

namespace g7mzr\restclient\common;

use g7mzr\restclient\RestError;

/**
 * RESTCLIENT Error Class
 *
 * This class implements an error object for RESTCLIENT
 */
class Error implements RestError
{

    /*
     * Property Error Message
     * @var string
     * @acess protected
     */
    protected $errorMsg = '';

    /*
     * Property Error Code
     * @var integer
     * @access protected
     */
    protected $errorCode = 0;

    /**
     * Constructor
     *
     * @param string  $errorMsg  The error message the exception has thrown.
     * @param integer $errorCode The code of the error.
     *
     * @access public
     */
    public function __construct(string $errorMsg = null, int $errorCode = null)
    {
        $this->errorMsg = $errorMsg;
        $this->errorCode = $errorCode;
    }

    /**
     * This function returns the error message
     *
     * @return string Return the error message.
     *
     * @access public
     */
    public function getMessage()
    {
        return $this->errorMsg;
    }

    /**
     * This function returns the error code
     *
     * @return integer The error code.
     *
     * @access public
     */
    public function getCode()
    {
        return $this->errorCode;
    }
}
