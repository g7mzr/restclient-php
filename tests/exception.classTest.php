<?php
/**
 * This file is part of RESTCLIENT.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package restclient-php
 * @subpackage tests
 * @author   Sandy McNeil <g7mzrdev@gmail.com>
 * @copyright (c) 2019, Sandy McNeil
 * @license https://github.com/g7mzr/restclient-php/blob/master/LICENSE GNU General Public License v3.0
 *
 */

namespace g7mzr\restclient\phpunit;

// Include the Class Autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use g7mzr\restclient\exception\RestException;

/**
 * Error Class Unit Tests
 *
 * This class contains the unit tests for the RESTCLIENT error class.
 */
class RESTExceptionTest extends TestCase
{
    /**
     * This function is called prior to any tests being run.
     * Its purpose is to set up any variables that are needed to tun the tests.
     *
     * @return void
     *
     * @access protected
     */
    protected function setUp()
    {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     *
     * @access protected
     */
    protected function tearDown()
    {
    }

    /**
     * This function is required to trow an exception to test RESTException
     *
     * @return void
     *
     * @throws RestException When called to test an RestException can be created.
     *
     * @access private
     */
    private function throwRestClientException()
    {
        throw new RestException("TEST EXCEPTION", 1);
    }

    /**
     * This function tests thar an error object can be created
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testException()
    {
        try {
            $this->throwRestClientException();
            $this->fail("Exception was not thrown");
        } catch (RestException $exc) {
            $this->assertEquals("TEST EXCEPTION", $exc->getMessage());
            $this->assertEquals(1, $exc->getCode());
        }
    }
}
