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
use g7mzr\restclient\common\RestException;
use \g7mzr\restclient\http\response\DecodeResponse;

/**
 * DecodeResponse Class Unit Tests
 *
 * This class contains the unit tests for the RESTCLIENT HTTP Response decoder class.
 */
class DecodeResponseTest extends TestCase
{

    /**
     * Property:  decodeRespone
     * @var \g7mzr\restclient\http\response\DecodeResponse
     * @access private
     */
    private $decodeResponse;

    /**
     * Property:  responseData
     * @var array
     * @access private
     */
    private $responseData = array();

    /**
     * Property: Data
     * @var string
     * @access private
     */
    private $data = "";

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
        $this->data = '{"name":"Test Application","Version":"4.5.0","API":"1.2.0"}';

        $this->responseData['http_code'] = "200";
        $this->responseData['download_content_length'] = strlen($this->data);
        $this->responseData['content_type'] = "application/json";

        $this->decodeResponse = new DecodeResponse(
            $this->responseData,
            $this->data
        );
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
     * This function tests that the HTTP response data is correct
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testHTTPResponce()
    {
        $httpResult = $this->decodeResponse->getHTTPResponseCode();
        $this->assertEquals("200", $httpResult);
    }

    /**
     * This function tests that an error is thrown if the HTTP response is missing
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testMissingHTTPResponse()
    {
        $responsestring = '{"name":"Test Application","Version""4.5.0","API":"1.2.0"}';
        //$responseData['http_code'] = "200";
        $responseData['download_content_length'] = strlen($this->data);
        $responseData['content_type'] = "application/json";

        try {
            $decodeResponse = new DecodeResponse($responseData, $responsestring);
            $this->fail("Exception was not thrown");
        } catch (\Throwable $exc) {
            $this->assertEquals("Failed to parse cURL Info", $exc->getMessage());
            $this->assertEquals(1, $exc->getCode());
        }
    }

    /**
     * This function tests that the length of the data packet is processed correctly
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testContentLength()
    {
        $expectedResult = $this->responseData['download_content_length'];
        $actualResult = $this->decodeResponse->getContentLength();
        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * This function tests that an error is thrown if the content length is missing
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testMissingContentLength()
    {
        $responsestring = '{"name":"Test Application","Version""4.5.0","API":"1.2.0"}';
        $responseData['http_code'] = "200";
        $responseData['content_type'] = "application/json";

        try {
            $decodeResponse = new DecodeResponse($responseData, $responsestring);
            $this->fail("Exception was not thrown");
        } catch (\Throwable $exc) {
            $this->assertEquals("Failed to parse cURL Info", $exc->getMessage());
            $this->assertEquals(1, $exc->getCode());
        }
    }

    /**
     * This function tests that the content type is processed correctly
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testContentType()
    {
        $expectedResult = $this->responseData['content_type'];
        $actualResult = $this->decodeResponse->getContentType();
        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * This function tests that the raw data is received correctly
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testRawData()
    {
        $expectedResult = $this->data;
        $actualResult = $this->decodeResponse->getRawData();
        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * This function tests that the raw data is processed correctly
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testProcessedData()
    {
        $expectedResult = json_decode($this->data, true);
        $actualResult = $this->decodeResponse->getProcessedData();

        foreach ($expectedResult as $key => $value) {
            $this->assertEquals($value, $actualResult[$key]);
        }
    }

    /**
     * This function tests that the the Webserver commands are returned
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testOptions()
    {
        $this->responseData['Content-Length'] = 0;
        $this->responseData['allow'] = "GET, HEAD, OPTIONS";

        $decodeResponse = new DecodeResponse($this->responseData, "");

        $expectedResult = array('GET', 'HEAD', 'OPTIONS');
        $actualResult = $decodeResponse->getAllow();

        foreach ($expectedResult as $key => $value) {
            $this->assertEquals($value, $actualResult[$key]);
        }
    }


    /**
     * This function checks to see of an error is thrown when incorrect data is parsed
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testInvalidData()
    {
        $responsestring = '{"name":"Test Application","Version""4.5.0","API":"1.2.0"}';

        try {
            $decodeResponse = new DecodeResponse($this->responseData, $responsestring);
            $this->fail("Exception was not thrown");
        } catch (\Throwable $exc) {
            $this->assertEquals("Failed to parse data", $exc->getMessage());
            $this->assertEquals(1, $exc->getCode());
        }
    }

    /**
     * This function checks to see of an error is thrown when incorrect data typeis parsed
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testInvalidDataType()
    {
        $this->responseData['content_type'] = "application/false";
        $responsestring = '{"name":"Test Application","Version":"4.5.0","API":"1.2.0"}';

        try {
            $decodeResponse = new DecodeResponse($this->responseData, $responsestring);
            $this->fail("Exception was not thrown");
        } catch (\Throwable $exc) {
            $this->assertEquals("Failed to parse data", $exc->getMessage());
            $this->assertEquals(1, $exc->getCode());
        }
    }
}
