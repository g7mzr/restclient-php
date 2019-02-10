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

/**
 * DecodeResponse Class Unit Tests
 *
 * This class contains the unit tests for the RESTCLIENT HTTP Response decoder class.
 */
class DecodeResponceTest extends TestCase
{

    /**
     * Property:  decodeResponce
     * @var \g7mzr\restclient\http\response\DecodeResponce
     * @access private
     */
    private $decodeResponce;

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

        $this->responseData['Date'] = "Sat, 19 Jan 2019 12:52:44 GMT";
        $this->responseData['Server'] = "Apache/2.4.23 (Linux/SUSE)";
        $this->responseData['X-Powered-By'] = "Mono";
        $this->responseData['Access-Control-Allow-Origin'] = "Origin";
        $this->responseData['Access-Control-Allow-Methods'] = "Methods";
        $this->responseData['X-Content-Type-Options'] = "nosniff";
        $this->responseData['Set-Cookie'] = "webdatabase=f9b0b9702e11e12fdb1df6e1ffc58b74; path=/; HttpOnly";
        $this->responseData['Content-Length'] = "" . strlen($this->data);
        $this->responseData['Content-Type'] = "application/json";

        $responsestring = "HTTP/1.1 200 OK\r\n";
        foreach ($this->responseData as $key => $value) {
            $responsestring .= $key . ": " . $value . "\r\n";
        }
        $responsestring .= "\r\n";
        $responsestring .= $this->data ."\r\n";

        $this->decodeResponce = new \g7mzr\restclient\http\response\DecodeResponse($responsestring);
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
        $httpResult = $this->decodeResponce->getHTTPResponce();
        $this->assertEquals("HTTP/1.1", $httpResult[0]);
        $this->assertEquals("200", $httpResult[1]);
        $this->assertEquals("OK", $httpResult[2]);
    }

    /**
     * This function tests that the date is encodes correctly
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testDate()
    {
        $expectedResult = strtotime($this->responseData['Date']);
        $actualResult = $this->decodeResponce->getHTTPDate();
        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * This function tests that the Server Name is correct
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testServer()
    {
        $expectedResult = $this->responseData['Server'];
        $actualResult = $this->decodeResponce->getServer();
        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * This function tests that the X-Powered-By Name is correct
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testXPoweredBy()
    {
        $expectedResult = $this->responseData['X-Powered-By'];
        $actualResult = $this->decodeResponce->getXPoweredBy();
        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * This function tests that the Access Control Data is Correct
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testAccessControl()
    {
        $expectedResult = array(
            "origin" => $this->responseData['Access-Control-Allow-Origin'],
            "methods" => $this->responseData['Access-Control-Allow-Methods']
        );
        $actualResult = $this->decodeResponce->getAccessControl();
        $this->assertEquals($expectedResult['origin'], $actualResult['origin']);
        $this->assertEquals($expectedResult['methods'], $actualResult['methods']);
    }

    /**
     * This function tests that the Content Type options are correct
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @acccess public
     */
    public function testContentTypeOptions()
    {
        $expectedResult = $this->responseData['X-Content-Type-Options'];
        $actualResult = $this->decodeResponce->getContentTypeOptions();
        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * This function tests that the Cookies received are decoded correctly
     *
     * @group unittest
     * @group decode
     *
     * @return void
     *
     * @access public
     */
    public function testCookies()
    {
        $expectedResult = $this->responseData['Set-Cookie'];
        $actualResult = $this->decodeResponce->getCookies();
        $this->assertEquals($expectedResult, $actualResult[0]);
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
        $expectedResult = $this->responseData['Content-Length'];
        $actualResult = $this->decodeResponce->getContentLength();
        $this->assertEquals($expectedResult, $actualResult);
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
        $expectedResult = $this->responseData['Content-Type'];
        $actualResult = $this->decodeResponce->getContentType();
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
        $actualResult = $this->decodeResponce->getRawData();
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
        $actualResult = $this->decodeResponce->getProcessedData();

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
        $this->responseData['Allow'] = "GET, HEAD, OPTIONS";
        $responsestring = "HTTP/1.1 200 OK\r\n";
        foreach ($this->responseData as $key => $value) {
            $responsestring .= $key . ": " . $value . "\r\n";
        }
        $responsestring .= "\r\n\r\n";

        $decodeResponce = new \g7mzr\restclient\http\response\DecodeResponse($responsestring);

        $expectedResult = array('GET', 'HEAD', 'OPTIONS');
        $actualResult = $decodeResponce->getAllow();

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
        $responsestring = "HTTP/1.1 200 OK\r\n";
        foreach ($this->responseData as $key => $value) {
            $responsestring .= $key . ": " . $value . "\r\n";
        }
        $responsestring .= "\r\n";
        $responsestring .= '{"name":"Test Application","Version""4.5.0","API":"1.2.0"}' ."\r\n";

        try {
            $decodeResponce = new \g7mzr\restclient\http\response\DecodeResponse($responsestring);
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
        $this->responseData['Content-Type'] = "application/false";
        $responsestring = "HTTP/1.1 200 OK\r\n";
        foreach ($this->responseData as $key => $value) {
            $responsestring .= $key . ": " . $value . "\r\n";
        }
        $responsestring .= "\r\n";
        $responsestring .= '{"name":"Test Application","Version":"4.5.0","API":"1.2.0"}' ."\r\n";

        try {
            $decodeResponce = new \g7mzr\restclient\http\response\DecodeResponse($responsestring);
            $this->fail("Exception was not thrown");
        } catch (\Throwable $exc) {
            $this->assertEquals("Failed to parse data", $exc->getMessage());
            $this->assertEquals(1, $exc->getCode());
        }
    }
}
