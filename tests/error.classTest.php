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

/**
 * DecodeResponse Class Unit Tests
 *
 * This class contains the unit tests for the RESTCLIENT HTTP Response decoder class.
 */
class ErrorTest extends TestCase
{
    /**
     * Error Class
     * @var \g7mzr\restclient\common\Error
     * @access protected
     */
    protected $object;


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
     * This function tests thar an error object can be created
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testError()
    {
        $err = new \g7mzr\restclient\common\Error('Test Error', 1);
        $this->assertEquals("Test Error", $err->getMessage());
        $this->assertEquals(1, $err->getCode());
    }

    /**
     * This function tests that an error object can be raised
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testRaiseError()
    {
        $err = \g7mzr\restclient\common\Common::raiseError('Test Error', 1);
        $this->assertEquals("Test Error", $err->getMessage());
        $this->assertEquals(1, $err->getCode());
    }

    /**
     * This function tests that isError works
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testisError()
    {
        $err = \g7mzr\restclient\common\Common::raiseError('Test Error', 1);
        $this->assertTrue(\g7mzr\restclient\common\Common::isError($err));
    }

    /**
     * This function tests that isError works
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testErrorMessage()
    {
        $OKMsg = \g7mzr\restclient\common\Common::errorMessage(API_OK);
        $this->assertEquals('No Error', $OKMsg);

        $unknownMsg = \g7mzr\restclient\common\Common::errorMessage(-9999);
        $this->assertEquals('Unknown Error', $unknownMsg);
    }
}
