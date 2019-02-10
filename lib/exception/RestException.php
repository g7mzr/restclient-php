<?php
/**
 * This file is part of  RESTCLIENT.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package restclient-php
 * @subpackage exception
 * @author   Sandy McNeil <g7mzrdev@gmail.com>
 * @copyright (c) 2019, Sandy McNeil
 * @license https://github.com/g7mzr/restclient-php/blob/master/LICENSE GNU General Public License v3.0
 *
 */

namespace g7mzr\restclient\exception;

use Exception;

/**
 * RESTCLIENT Exception Class
 *
 * This is the exception class for RESTCLIENT. This version make the message mandatory
 * unlike the PHP version
 */
class RestException extends Exception
{
    /**
     * Constructor for RestException.
     *
     * RestClient Exception makes the message mandatory unlike the PHP version
     *
     * @param string    $message  The DB Exception message to throw.
     * @param integer   $code     The Exception code.
     * @param Throwable $previous The previous exception used for chaining.
     *
     * @access public
     */
    public function __construct(
        string $message,
        int $code = 0,
        Throwable $previous = null
    ) {
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
}
