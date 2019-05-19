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
use g7mzr\restclient\options\Options;

/**
 * Header Class Unit Tests
 *
 * This class contains the unit tests for the RESTCLIENT Header class.
 */
class RestOptionsTest extends TestCase
{
    /**
     * Property:  decodeResponce
     * @var \g7mzr\restclient\RestOptions
     * @access private
     */
    private $restOptions;

    /**
     * This function is called prior to any tests being run.
     * Its purpose is to set up any variables that are needed to tun the tests.
     *
     * @return void
     *
     * @access protected
     */
    protected function setUp(): void
    {
        $this->restOptions = new Options();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     *
     * @access protected
     */
    protected function tearDown(): void
    {
    }

    /**
     * This function tests that the base URL can be saved and retrieved
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testBaseURL()
    {
        // Test if the URL is not set a empty string is returned
        $defaultResult = $this->restOptions->getBaseURL();
        $this->assertEquals("", $defaultResult);

        // Set the base URL
        $testData = "www.example.com";
        $setResult = $this->restOptions->setBaseURL($testData);
        $this->assertTrue(is_a($setResult, 'g7mzr\restclient\RestOptions'));

        // Test the URL can be retrieved
        $getResult = $this->restOptions->getBaseURL();
        $this->assertEquals($testData . '/', $getResult);
    }

    /**
     * This function tests that the proxy server address can be saved and retrieved
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testProxyServer()
    {
        // Test if the Server Address is not set a empty string is returned
        $defaultResult = $this->restOptions->getProxyServer();
        $this->assertEquals("", $defaultResult);

        // Set the Server Address
        $testData = "127.0.0.1";
        $setResult = $this->restOptions->setProxyServer($testData);
        $this->assertTrue(is_a($setResult, 'g7mzr\restclient\RestOptions'));

        // Test the server address can be retrieved
        $getResult = $this->restOptions->getProxyServer();
        $this->assertEquals($testData, $getResult);
    }

    /**
     * This function tests that the proxy server port can be saved and retrieved
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testProxyServerPort()
    {
        // Test if the Server port is not set a empty string is returned
        $defaultResult = $this->restOptions->getProxyServerPort();
        $this->assertEquals("", $defaultResult);

        // Set the Server Address
        $testData = "8080";
        $setResult = $this->restOptions->setProxyServerPort($testData);
        $this->assertTrue(is_a($setResult, 'g7mzr\restclient\RestOptions'));

        // Test the server address can be retrieved
        $getResult = $this->restOptions->getProxyServerPort();
        $this->assertEquals($testData, $getResult);
    }

    /**
     * This function tests that the user agent string can be saved and retrieved
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testUserAgent()
    {
        // Test the default UserAgent String is returned
        $defaultResult = $this->restOptions->getUserAgent();
        $this->assertStringContainsString("PHP RESTFull API Client", $defaultResult);

        // Set the User Agent
        $testData = "PHP RESTCLIENT 1.0/cURL";
        $setResult = $this->restOptions->setUserAgent($testData);
        $this->assertTrue(is_a($setResult, 'g7mzr\restclient\RestOptions'));

        // Test the user agent can be retrieved
        $getResult = $this->restOptions->getUserAgent();
        $this->assertEquals($testData, $getResult);
    }

    /**
     * This function tests that the cookie filename can be saved and retrieved
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testCookieFile()
    {
        // Test the default UserAgent String is returned
        $defaultResult = $this->restOptions->getCookiefile();
        $this->assertStringContainsString("", $defaultResult);

        // Set the User Agent
        $testData = __FILE__;
        $setResult = $this->restOptions->setCookieFile($testData);
        $this->assertTrue(is_a($setResult, 'g7mzr\restclient\RestOptions'));

        // Test the user agent can be retrieved
        $getResult = $this->restOptions->getCookiefile();
        $this->assertEquals($testData, $getResult);
    }
}
