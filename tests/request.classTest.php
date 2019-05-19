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
use g7mzr\restclient\http\request\Request;

/**
 * Header Class Unit Tests
 *
 * This class contains the unit tests for the RESTCLIENT Header class.
 */
class RestRequestTest extends TestCase
{
    /**
     * Property:  restRequest
     * @var \g7mzr\restclient\RestRequest
     * @access private
     */
    private $restRequest;

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
        $this->restRequest = new Request();
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
     * This function tests that the API Endpoint can be saved and retrieved
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testEndpoint()
    {
        // Test if the endpoint is not set a empty string is returned
        $defaultResult = $this->restRequest->getEndPoint();
        $this->assertEquals("", $defaultResult);

        // Set the endpoint
        $testData = "api/v1/version";
        $setResult = $this->restRequest->setEndPoint($testData);
        $this->assertTrue(is_a($setResult, 'g7mzr\restclient\RestRequest'));

        // Test the endpoint can be retrieved
        $getResult = $this->restRequest->getEndPoint();
        $this->assertEquals($testData, $getResult);
    }

    /**
     * This function tests that the HTTP Request Header can be saved and retrieved
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testAcceptHeader()
    {
        // Test if Accept Header is set to the default value
        $defaultResult = $this->restRequest->getAcceptHeader();
        $this->assertEquals("application/json", $defaultResult);

        // Set the endpoint
        $testData = "application/xml";
        $setResult = $this->restRequest->setAcceptHeader($testData);
        $this->assertTrue(is_a($setResult, 'g7mzr\restclient\RestRequest'));

        // Test the endpoint can be retrieved
        $getResult = $this->restRequest->getAcceptHeader();
        $this->assertEquals($testData, $getResult);
    }

    /**
     * This function tests that URL Encoded data can be created with only one
     * key/data pair in the array.
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testURLEncodedDataSingleEntry()
    {
        // Test there is no data when the class is initalised
        $defaultResult = $this->restRequest->getURLEncodedData();
        $this->assertEquals("", $defaultResult);

        // Set URL Encoded Data
        $testData = array(
           "username" => "testuser"
        );
        $encodedtestdata = "username=testuser";
        $setResult = $this->restRequest->setURLEncodedData($testData);
        $this->assertTrue(is_a($setResult, 'g7mzr\restclient\RestRequest'));

        // Test the endpoint can be retrieved
        $getResult = $this->restRequest->getURLEncodedData();
        $this->assertEquals($encodedtestdata, $getResult);
    }

    /**
     * This function tests that URL Encoded data can be created with more than one
     * key/data pair in the array.
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testURLEncodedDataMultipleEntries()
    {
        // Test there is no data when the class is initalised
        $defaultResult = $this->restRequest->getURLEncodedData();
        $this->assertEquals("", $defaultResult);

        // Set URL Encoded Data
        $testData = array(
           "username" => "testuser",
           "password" => "testpassword"
        );
        $encodedtestdata = http_build_query($testData);
        $setResult = $this->restRequest->setURLEncodedData($testData);
        $this->assertTrue(is_a($setResult, 'g7mzr\restclient\RestRequest'));

        // Test the endpoint can be retrieved
        $getResult = $this->restRequest->getURLEncodedData();
        $this->assertEquals($encodedtestdata, $getResult);
    }

    /**
     * This function tests that JSON Encoded data can be created with only one
     * key/data pair in the array.
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testJSONEncodedDataSingleEntry()
    {
        // Test there is no data when the class is initalised
        $defaultResult = $this->restRequest->getJSONEncodedData();
        $this->assertEquals("{}", $defaultResult);

        // Set URL Encoded Data
        $testData = array(
           "username" => "testuser"
        );
        $encodedtestdata = '{"username":"testuser"}';
        $setResult = $this->restRequest->setJSONEncodedData($testData);
        $this->assertTrue(is_a($setResult, 'g7mzr\restclient\RestRequest'));

        // Test the endpoint can be retrieved
        $getResult = $this->restRequest->getJSONEncodedData();
        $this->assertEquals($encodedtestdata, $getResult);
    }

    /**
     * This function tests that JSON Encoded data can be created with more than one
     * key/data pair in the array.
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testJSONEncodedDataMultiple()
    {
        // Test there is no data when the class is initalised
        $defaultResult = $this->restRequest->getJSONEncodedData();
        $this->assertEquals("{}", $defaultResult);

        // Set URL Encoded Data
        $testData = array(
           "username" => "testuser",
           "password" => "testpassword"
        );
        $encodedtestdata = '{"username":"testuser","password":"testpassword"}';
        $setResult = $this->restRequest->setJSONEncodedData($testData);
        $this->assertTrue(is_a($setResult, 'g7mzr\restclient\RestRequest'));

        // Test the endpoint can be retrieved
        $getResult = $this->restRequest->getJSONEncodedData();
        $this->assertEquals($encodedtestdata, $getResult);
    }

    /**
     * This function tests that URL Arguments can be created as an array and retrieved
     * as a string
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testURLArguments()
    {
        // Test there is no data when the class is initalised
        $defaultResult = $this->restRequest->getURLArguments();
        $this->assertEquals("", $defaultResult);

        // Set the URL encoded arguments
        $testData = array("users", "1");
        $encodedtestdata = '/users/1';
        $setResult = $this->restRequest->setURLArguments($testData);
        $this->assertTrue(is_a($setResult, 'g7mzr\restclient\RestRequest'));

        // Test the endpoint can be retrieved
        $getResult = $this->restRequest->getURLArguments();
        $this->assertEquals($encodedtestdata, $getResult);
    }
}
