<?php
/**
 * This file is part of RESTCLIENT
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
require_once __DIR__ . '/constants.php';

use PHPUnit\Framework\TestCase;
use g7mzr\restclient\http\APIClient;
use g7mzr\restclient\options\Options;
use g7mzr\restclient\http\request\Request;
use g7mzr\restclient\common\Common;

/**
 * RestClientAPI Tests
 *
 * This class contains restclient API tests
 */
class RestAPITest extends TestCase
{
    /**
     * Property: apiclient
     * @var \g7mzr\restclient\http\APIClient
     * @access protected
     */
    protected $apiclient;

    /**
     * Property: options
     * @var \g7mzr\restclient\options\Options
     * @access protected
     */
    protected $options;

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
        $this->options = new Options();
        $this->options->setBaseURL(URL);
        $this->options->setCookieFile(__DIR__ . "/cookies.txt");

        if (PROXY === true) {
            $this->options->setProxyServer(HTTPPROXY);
        }
        $this->apiclient = new APIClient($this->options);
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
     * Test the Destructor
     *
     * This function tests the getError method.  When called prior to running a
     * HTTP Method it should return an empty array
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testDestructor()
    {
        // Check that $this->apiclient is a g7mzr\restclient\http\APIClient
        $this->assertTrue(is_a($this->apiclient, 'g7mzr\restclient\http\APIClient'));

        // Run a request
        $getrequest = new Request();
        $getrequest->setEndPoint("api/v1/version");

        $runok = $this->apiclient->httpGet($getrequest);
        if (Common::isError($runok)) {
            $this->fail("cURL failed to run correctly for test: " .  __FUNCTION__);
        }

        // Get the response data
        $getresponse = $this->apiclient->getResponse();

        // Check the http response
        $httpresponse = $getresponse->getHTTPResponseCode();
        $this->assertEquals("200", $httpresponse);

        // Delete the apiclient and check it is done.
        $this->apiclient = null;
        $this->assertFalse(is_a($this->apiclient, 'g7mzr\restclient\http\APIClient'));
    }

    /**
     * testGetNoARGS
     *
     * This function tests that GET can be called with no Arguments.
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testGETNoARGS()
    {
        $getrequest = new Request();
        $getrequest->setEndPoint("api/v1/version");

        $runok = $this->apiclient->httpGet($getrequest);
        if (Common::isError($runok)) {
            $this->fail("cURL failed to run correctly for test: " .  __FUNCTION__);
        }


        // Get the respose data
        $getresponse = $this->apiclient->getResponse();

        // Check the http response
        $httpresponse = $getresponse->getHTTPResponseCode();
        $this->assertEquals("200", $httpresponse);

        // Check the returned data
        $processeddata = $getresponse->getProcessedData();
        $this->assertEquals("version", $processeddata['endpoint']);
        $this->assertEquals("GET", $processeddata['method']);
        $this->assertEquals(0, count($processeddata['args']));
        $this->assertEquals(0, count($processeddata['requestdata']));
        $this->assertEquals("", $processeddata['contenttype']);
        $this->assertEquals("application/json", $processeddata['accepttype']);
    }

    /**
     * testGetTwoARGS
     *
     * This function tests that GET can be called with two Arguments and they are
     * returned in the data array in the args section.
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testGETTwoARGS()
    {
        $getrequest = new Request();
        $getrequest->setEndPoint("api/v1/version");

        $arguments = array("argsone", "argstwo");
        $getrequest->setURLArguments($arguments);

        $runok = $this->apiclient->httpGet($getrequest);
        if (Common::isError($runok)) {
            $this->fail("cURL failed to run correctly for test: " .  __FUNCTION__);
        }


        // Get the respose data
        $getresponse = $this->apiclient->getResponse();

        // Check the http response
        $httpresponse = $getresponse->getHTTPResponseCode();
        $this->assertEquals("200", $httpresponse);

        // Check the returned data
        $processeddata = $getresponse->getProcessedData();
        $this->assertEquals("version", $processeddata['endpoint']);
        $this->assertEquals("GET", $processeddata['method']);
        $this->assertEquals(2, count($processeddata['args']));
        $this->assertEquals(2, count($processeddata['requestdata']));
        $this->assertEquals("", $processeddata['contenttype']);
        $this->assertEquals("application/json", $processeddata['accepttype']);
        $this->assertEquals("argsone", $processeddata['args'][0]);
        $this->assertEquals("argstwo", $processeddata['args'][1]);
    }

    /**
     * Test if GET is called with no endpoint set
     *
     * Test that an error is returned if GET is called without an endpoint set
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testGETNoEndPoint()
    {
        $getrequest = new Request();
        $runok = $this->apiclient->httpGet($getrequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(2, $runok->getCode());
        $this->assertEquals(
            'Error Setting Base URL and End Point in setCurlOption',
            $runok->getMessage()
        );
    }

    /**
     * Test if GET is called with no AcceptHeader set
     *
     * Test that an error is returned if GET is called without an AcceptHeader set
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testGETNoAcceptHeader()
    {
        $getrequest = new Request();
        $getrequest->setEndPoint("api/v1/version");
        $getrequest->setAcceptHeader("");
        $runok = $this->apiclient->httpGet($getrequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(2, $runok->getCode());
        $this->assertEquals(
            'Error Setting Accept Header in setCurlOption',
            $runok->getMessage()
        );
    }

    /**
     * Test if GET is with invalid URL
     *
     * Test that an error is returned if GET is called with an invalid URL
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testGETInvalidURL()
    {
        $this->options->setBaseURL(BADURL);
        $apiclient = new APIClient($this->options);
        $getrequest = new Request();
        $getrequest->setEndPoint("api/v1/version");
        $runok = $apiclient->httpGet($getrequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(3, $runok->getCode());
        $this->assertContains(
            'Could not resolve host:',
            $runok->getMessage()
        );
    }

    /**
     * testOptions
     *
     * This function tests the Options command can be sent to the webserver correctly.
     * Only the options are returned as part of the header with no data.
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testOptions()
    {
        $optionsrequest = new Request();
        $optionsrequest->setEndPoint("api/v1/version");

        $runok = $this->apiclient->httpOptions($optionsrequest);
        if (Common::isError($runok)) {
            $this->fail("cURL failed to run correctly for test: " .  __FUNCTION__);
        }


        $optionsresponse = $this->apiclient->getResponse();

        // Check that no data is returned
        $contentlength = $optionsresponse->getContentLength();
        $this->assertEquals(0, $contentlength);

        // Check the http response
        $httpresponse = $optionsresponse->getHTTPResponseCode();
        $this->assertEquals("200", $httpresponse);

        // Check the returned data
        $expectedResult = array('GET', 'HEAD', 'OPTIONS');
        $actualResult = $optionsresponse->getAllow();

        foreach ($expectedResult as $key => $value) {
            $this->assertEquals($value, $actualResult[$key]);
        }
    }

    /**
     * Test if OPTIONS is called with no endpoint set
     *
     * Test that an error is returned if OPTIONS is called without an endpoint set
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testOPTIONSNoEndPoint()
    {
        $optionsrequest = new Request();
        $runok = $this->apiclient->httpOptions($optionsrequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(2, $runok->getCode());
        $this->assertEquals(
            'Error Setting Base URL and End Point in setCurlOption',
            $runok->getMessage()
        );
    }

    /**
     * Test if OPTIONS is called with no AcceptHeader set
     *
     * Test that an error is returned if Options is called without an AcceptHeader set
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testOPTIONSNoAcceptHeader()
    {
        $optionsrequest = new Request();
        $optionsrequest->setEndPoint("api/v1/version");
        $optionsrequest->setAcceptHeader("");
        $runok = $this->apiclient->httpOptions($optionsrequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(2, $runok->getCode());
        $this->assertEquals(
            'Error Setting Accept Header in setCurlOption',
            $runok->getMessage()
        );
    }

    /**
     * Test if OPTIONS is with invalid URL
     *
     * Test that an error is returned if OPTIONS is called with an invalid URL
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testOptionsInvalidURL()
    {
        $this->options->setBaseURL(BADURL);
        $apiclient = new APIClient($this->options);
        $optionsrequest = new Request();
        $optionsrequest->setEndPoint("api/v1/version");
        $runok = $apiclient->httpOptions($optionsrequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(3, $runok->getCode());
        $this->assertContains(
            'Could not resolve host:',
            $runok->getMessage()
        );
    }

    /**
     * testHead
     *
     * This function tests the HEAD command can be sent to the webserver correctly.
     * Only the header with no data.
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testHead()
    {
        $headrequest = new Request();
        $headrequest->setEndPoint("api/v1/version");

        $runok = $this->apiclient->httpHead($headrequest);
        if (Common::isError($runok)) {
            $this->fail("cURL failed to run correctly for test: " .  __FUNCTION__);
        }

        $headresponse = $this->apiclient->getResponse();

        // Check the http response
        $httpresponse = $headresponse->getHTTPResponseCode();
        $this->assertEquals("200", $httpresponse);

        // Check that no data is returned
        $contentlength = $headresponse->getContentLength();
        $this->assertEquals(56, $contentlength);

        // Check No data is available
        $returneddata = $headresponse->getRawData();
        $this->assertEquals("", $returneddata);
    }

    /**
     * Test if HEAD is called with no endpoint set
     *
     * Test that an error is returned if HEAD is called without an endpoint set
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testHEADNoEndPoint()
    {
        $headrequest = new Request();
        $runok = $this->apiclient->httpHead($headrequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(2, $runok->getCode());
        $this->assertEquals(
            'Error Setting Base URL and End Point in setCurlOption',
            $runok->getMessage()
        );
    }

    /**
     * Test if HEAD is called with no AcceptHeader set
     *
     * Test that an error is returned if HEAD is called without an AcceptHeader set
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testHEADNoAcceptHeader()
    {
        $headrequest = new Request();
        $headrequest->setEndPoint("api/v1/version");
        $headrequest->setAcceptHeader("");
        $runok = $this->apiclient->httpHead($headrequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(2, $runok->getCode());
        $this->assertEquals(
            'Error Setting Accept Header in setCurlOption',
            $runok->getMessage()
        );
    }

    /**
     * Test if HEAD is with invalid URL
     *
     * Test that an error is returned if HEAD is called with an invalid URL
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testHEADInvalidURL()
    {
        $this->options->setBaseURL(BADURL);
        $apiclient = new APIClient($this->options);
        $getrequest = new Request();
        $getrequest->setEndPoint("api/v1/version");
        $runok = $apiclient->httpHead($getrequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(3, $runok->getCode());
        $this->assertContains(
            'Could not resolve host:',
            $runok->getMessage()
        );
    }

    /**
     * testPOSTURLEncodedOptionsNoArgs
     *
     * This function tests the POST command can be sent to the webserver correctly.
     * Data is urlencoded before being sent.  There are no arguments as part of the URL
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testPOSTURLEncodedOptionsNoArgs()
    {
        $postrequest = new Request();
        $postrequest->setEndPoint("api/v1/version");
        $testData = array(
           "username" => "testuser",
           "password" => "testpassword"
        );
        $postrequest->setURLEncodedData($testData);
        $runok = $this->apiclient->httpPost($postrequest);
        if (Common::isError($runok)) {
            $this->fail("cURL failed to run correctly for test: " .  __FUNCTION__);
        }


        $postresponse = $this->apiclient->getResponse();
        // Check the http response
        $httpresponse = $postresponse->getHTTPResponseCode();
        $this->assertEquals("200", $httpresponse);

        $decodedData = $postresponse->getProcessedData();
        $this->assertEquals("version", $decodedData['endpoint']);
        $this->assertEquals("POST", $decodedData['method']);
        $this->assertEquals(0, count($decodedData['args']));
        $this->assertEquals(2, count($decodedData['requestdata']));
        $this->assertEquals("application/x-www-form-urlencoded", $decodedData['contenttype']);
        $this->assertEquals("application/json", $decodedData['accepttype']);
        foreach ($decodedData['requestdata'] as $key => $value) {
            $this->assertEquals($testData[$key], $value);
        }
    }

    /**
     * testPOSTURLEncodedOptionsTwoArgs
     *
     * This function tests the POST command can be sent to the webserver correctly.
     * Data is urlencoded before being sent.  There are two arguments as part of the URL
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testPOSTURLEncodedOptionsTwoArgs()
    {
        $postrequest = new Request();
        $postrequest->setEndPoint("api/v1/version");
        $arguments = array("users", "1");
        $postrequest->setURLArguments($arguments);
        $testData = array(
           "username" => "testuser",
           "password" => "testpassword"
        );
        $postrequest->setURLEncodedData($testData);
        $runok = $this->apiclient->httpPost($postrequest);
        if (Common::isError($runok)) {
            $this->fail("cURL failed to run correctly for test: " .  __FUNCTION__);
        }
        $postresponse = $this->apiclient->getResponse();
        // Check the http response
        $httpresponse = $postresponse->getHTTPResponseCode();
        $this->assertEquals("200", $httpresponse);

        $decodedData = $postresponse->getProcessedData();
        $this->assertEquals("version", $decodedData['endpoint']);
        $this->assertEquals("POST", $decodedData['method']);
        $this->assertEquals(2, count($decodedData['args']));
        $this->assertEquals(2, count($decodedData['requestdata']));
        $this->assertEquals("application/x-www-form-urlencoded", $decodedData['contenttype']);
        $this->assertEquals("application/json", $decodedData['accepttype']);
        foreach ($decodedData['requestdata'] as $key => $value) {
            $this->assertEquals($testData[$key], $value);
        }
        $this->assertEquals("users", $decodedData['args'][0]);
        $this->assertEquals("1", $decodedData['args'][1]);
    }

    /**
     * testPOSTJSONEncodedOptionsNoArgs
     *
     * This function tests the POST command can be sent to the webserver correctly.
     * Data is JSON before being sent.  There are no arguments as part of the URL
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testPOSTJSONEncodedOptionsNoArgs()
    {
        $postrequest = new Request();
        $postrequest->setEndPoint("api/v1/version");
        $testData = array(
           "username" => "testuser",
           "password" => "testpassword"
        );
        $postrequest->setJSONEncodedData($testData);
        $runok = $this->apiclient->httpPost($postrequest);
        if (Common::isError($runok)) {
            $this->fail("cURL failed to run correctly for test: " .  __FUNCTION__);
        }
        $postresponse = $this->apiclient->getResponse();
        // Check the http response
        $httpresponse = $postresponse->getHTTPResponseCode();
        $this->assertEquals("200", $httpresponse);

        $decodedData = $postresponse->getProcessedData();
        $this->assertEquals("version", $decodedData['endpoint']);
        $this->assertEquals("POST", $decodedData['method']);
        $this->assertEquals(0, count($decodedData['args']));
        $this->assertEquals(2, count($decodedData['requestdata']));
        $this->assertEquals("application/json", $decodedData['contenttype']);
        $this->assertEquals("application/json", $decodedData['accepttype']);
        foreach ($decodedData['requestdata'] as $key => $value) {
            $this->assertEquals($testData[$key], $value);
        }
    }

    /**
     * testPOSTNoData
     *
     * This function tests the POST command can be sent to the webserver correctly.
     * No Data is being sent.  There are no arguments as part of the URL
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testPOSTNoData()
    {
        $postrequest = new Request();
        $postrequest->setEndPoint("api/v1/version");
        $runok = $this->apiclient->httpPost($postrequest);
        if (Common::isError($runok)) {
            $this->fail("cURL failed to run correctly for test: " .  __FUNCTION__);
        }


        $postresponse = $this->apiclient->getResponse();
        // Check the http response
        $httpresponse = $postresponse->getHTTPResponseCode();
        $this->assertEquals("200", $httpresponse);

        $decodedData = $postresponse->getProcessedData();
        $this->assertEquals("version", $decodedData['endpoint']);
        $this->assertEquals("POST", $decodedData['method']);
        $this->assertEquals(0, count($decodedData['args']));
        $this->assertEquals("", $decodedData['requestdata']);
        $this->assertEquals("text/plain; charset=ISO-8859-1", $decodedData['contenttype']);
        $this->assertEquals("application/json", $decodedData['accepttype']);
    }

    /**
     * Test if POST is called with no endpoint set
     *
     * Test that an error is returned if POST is called without an endpoint set
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testPOSTNoEndPoint()
    {
        $postrequest = new Request();
        $testData = array(
           "username" => "testuser",
           "password" => "testpassword"
        );
        $postrequest->setJSONEncodedData($testData);
        $runok = $this->apiclient->httpPost($postrequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(2, $runok->getCode());
        $this->assertEquals(
            'Error Setting Base URL and End Point in setCurlOption',
            $runok->getMessage()
        );
    }

    /**
     * Test if POST is called with no AcceptHeader set
     *
     * Test that an error is returned if POST is called without an AcceptHeader set
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testPOSTNoAcceptHeader()
    {
        $postrequest = new Request();
        $postrequest->setEndPoint("api/v1/version");
        $postrequest->setAcceptHeader("");
        $testData = array(
           "username" => "testuser",
           "password" => "testpassword"
        );
        $postrequest->setJSONEncodedData($testData);

        $runok = $this->apiclient->httpPost($postrequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(2, $runok->getCode());
        $this->assertEquals(
            'Error Setting Accept Header in setCurlOption',
            $runok->getMessage()
        );
    }

    /**
     * Test if POST is with invalid URL
     *
     * Test that an error is returned if POST is called with an invalid URL
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testPOSTInvalidURL()
    {
        $this->options->setBaseURL(BADURL);
        $apiclient = new APIClient($this->options);
        $postrequest = new Request();
        $postrequest->setEndPoint("api/v1/version");
        $runok = $apiclient->httpPost($postrequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(3, $runok->getCode());
        $this->assertContains(
            'Could not resolve host:',
            $runok->getMessage()
        );
    }

    /**
     * testPUTURLEncodedOptionsNoArgs
     *
     * This function tests the PUT command can be sent to the webserver correctly.
     * Data is urlencoded before being sent.  There are no arguments as part of the
     * URL so the command should fail.
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testPUTURLEncodedOptionsNoArgs()
    {
        $putrequest = new Request();
        $putrequest->setEndPoint("api/v1/version");
        $testData = array(
           "username" => "testuser",
           "password" => "testpassword"
        );
        $putrequest->setURLEncodedData($testData);
        $runok = $this->apiclient->httpPut($putrequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(4, $runok->getCode());
        $this->assertContains(
            'Arguments have not been included for PUT COMMAND',
            $runok->getMessage()
        );
    }

    /**
     * testPUTURLEncodedOptionsTwoArgs
     *
     * This function tests the PUT command can be sent to the webserver correctly.
     * Data is urlencoded before being sent.  There are two arguments as part of the URL
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testPUTURLEncodedOptionsTwoArgs()
    {
        $putrequest = new Request();
        $putrequest->setEndPoint("api/v1/version");
        $arguments = array("users", "1");
        $putrequest->setURLArguments($arguments);

        $testData = array(
           "username" => "testuser",
           "password" => "testpassword"
        );
        $putrequest->setURLEncodedData($testData);
        $runok = $this->apiclient->httpPut($putrequest);
        if (Common::isError($runok)) {
            $this->fail("cURL failed to run correctly for test: " .  __FUNCTION__);
        }
        $putresponse = $this->apiclient->getResponse();
        // Check the http response
        $httpresponse = $putresponse->getHTTPResponseCode();
        $this->assertEquals("200", $httpresponse);

        $decodedData = $putresponse->getProcessedData();
        $this->assertEquals("version", $decodedData['endpoint']);
        $this->assertEquals("PUT", $decodedData['method']);
        $this->assertEquals(2, count($decodedData['args']));
        $this->assertEquals(2, count($decodedData['requestdata']));
        $this->assertEquals("application/x-www-form-urlencoded", $decodedData['contenttype']);
        $this->assertEquals("application/json", $decodedData['accepttype']);
        foreach ($decodedData['requestdata'] as $key => $value) {
            $this->assertEquals($testData[$key], $value);
        }
        $this->assertEquals("users", $decodedData['args'][0]);
        $this->assertEquals("1", $decodedData['args'][1]);
    }

    /**
     * testPUTJSONEncodedOptionsNoArgs
     *
     * This function tests the PUT command can be sent to the webserver correctly.
     * Data is JSON before being sent.  There are Two arguments as part of the URL
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testPUTJSONEncodedOptionsTwoArgs()
    {
        $putrequest = new Request();
        $putrequest->setEndPoint("api/v1/version");
        $arguments = array("users", "1");
        $putrequest->setURLArguments($arguments);
        $testData = array(
           "username" => "testuser",
           "password" => "testpassword"
        );
        $putrequest->setJSONEncodedData($testData);
        $runok = $this->apiclient->httpPut($putrequest);
        if (Common::isError($runok)) {
            $this->fail("cURL failed to run correctly for test: " .  __FUNCTION__);
        }
        $putresponse = $this->apiclient->getResponse();
        // Check the http response
        $httpresponse = $putresponse->getHTTPResponseCode();
        $this->assertEquals("200", $httpresponse);

        $decodedData = $putresponse->getProcessedData();
        $this->assertEquals("version", $decodedData['endpoint']);
        $this->assertEquals("PUT", $decodedData['method']);
        $this->assertEquals(2, count($decodedData['args']));
        $this->assertEquals(2, count($decodedData['requestdata']));
        $this->assertEquals("application/json", $decodedData['contenttype']);
        $this->assertEquals("application/json", $decodedData['accepttype']);
        foreach ($decodedData['requestdata'] as $key => $value) {
            $this->assertEquals($testData[$key], $value);
        }
        $this->assertEquals("users", $decodedData['args'][0]);
        $this->assertEquals("1", $decodedData['args'][1]);
    }

    /**
     * Test if PUT is called with no endpoint set
     *
     * Test that an error is returned if PUT is called without an endpoint set
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testPUTNoEndPoint()
    {
        $putrequest = new Request();
        $arguments = array("users", "1");
        $putrequest->setURLArguments($arguments);
        $testData = array(
           "username" => "testuser",
           "password" => "testpassword"
        );
        $putrequest->setJSONEncodedData($testData);
        $runok = $this->apiclient->httpPut($putrequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(2, $runok->getCode());
        $this->assertEquals(
            'Error Setting Base URL and End Point in setCurlOption',
            $runok->getMessage()
        );
    }

    /**
     * Test if PUT is called with no AcceptHeader set
     *
     * Test that an error is returned if PUT is called without an AcceptHeader set
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testPUTNoAcceptHeader()
    {
        $putrequest = new Request();
        $arguments = array("users", "1");
        $putrequest->setURLArguments($arguments);
        $putrequest->setEndPoint("api/v1/version");
        $putrequest->setAcceptHeader("");
        $testData = array(
           "username" => "testuser",
           "password" => "testpassword"
        );
        $putrequest->setJSONEncodedData($testData);

        $runok = $this->apiclient->httpPut($putrequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(2, $runok->getCode());
        $this->assertEquals(
            'Error Setting Accept Header in setCurlOption',
            $runok->getMessage()
        );
    }

    /**
     * Test if PUT is with invalid URL
     *
     * Test that an error is returned if PUT is called with an invalid URL
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testPUTInvalidURL()
    {
        $this->options->setBaseURL(BADURL);
        $apiclient = new APIClient($this->options);
        $putrequest = new Request();
        $putrequest->setEndPoint("api/v1/version");
        $arguments = array("users", "1");
        $putrequest->setURLArguments($arguments);
        $runok = $apiclient->httpPut($putrequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(3, $runok->getCode());
        $this->assertContains(
            'Could not resolve host:',
            $runok->getMessage()
        );
    }

    /**
     * testDELETEURLEncodedOptionsNoArgs
     *
     * This function tests the DELETE command can be sent to the webserver correctly.
     * Data is urlencoded before being sent.  There are no arguments as part of the
     * URL so the command should fail.
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testDELETENoArgs()
    {
        $deleterequest = new Request();
        $deleterequest->setEndPoint("api/v1/version");
        $runok = $this->apiclient->httpDelete($deleterequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(4, $runok->getCode());
        $this->assertContains(
            'Arguments have not been included for DELETE COMMAND',
            $runok->getMessage()
        );
    }

    /**
     * testDELETEURLEncodedOptionsTwoArgs
     *
     * This function tests the DELETE command can be sent to the webserver correctly.
     * Data is urlencoded before being sent.  There are two arguments as part of the URL
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testDELETETwoArgs()
    {
        $deleterequest = new Request();
        $deleterequest->setEndPoint("api/v1/version");
        $arguments = array("users", "1");
        $deleterequest->setURLArguments($arguments);

        $runok = $this->apiclient->httpDelete($deleterequest);
        if (Common::isError($runok)) {
            $this->fail("cURL failed to run correctly for test: " .  __FUNCTION__);
        }
        $deleteresponse = $this->apiclient->getResponse();
        // Check the http response
        $httpresponse = $deleteresponse->getHTTPResponseCode();
        $this->assertEquals("200", $httpresponse);

        $decodedData = $deleteresponse->getProcessedData();
        $this->assertEquals("version", $decodedData['endpoint']);
        $this->assertEquals("DELETE", $decodedData['method']);
        $this->assertEquals(2, count($decodedData['args']));
        $this->assertEquals(2, count($decodedData['requestdata']));
        $this->assertEquals("", $decodedData['contenttype']);
        $this->assertEquals("application/json", $decodedData['accepttype']);
        $this->assertEquals("users", $decodedData['args'][0]);
        $this->assertEquals("1", $decodedData['args'][1]);
    }

    /**
     * Test if DELETE is called with no endpoint set
     *
     * Test that an error is returned if DELETE is called without an endpoint set
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testDELETENoEndPoint()
    {
        $deleterequest = new Request();
        $arguments = array("users", "1");
        $deleterequest->setURLArguments($arguments);
        $testData = array(
           "username" => "testuser",
           "password" => "testpassword"
        );
        $deleterequest->setJSONEncodedData($testData);
        $runok = $this->apiclient->httpDelete($deleterequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(2, $runok->getCode());
        $this->assertEquals(
            'Error Setting Base URL and End Point in setCurlOption',
            $runok->getMessage()
        );
    }

    /**
     * Test if DELETE is called with no AcceptHeader set
     *
     * Test that an error is returned if DELETE is called without an AcceptHeader set
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testDELETENoAcceptHeader()
    {
        $deleterequest = new Request();
        $arguments = array("users", "1");
        $deleterequest->setURLArguments($arguments);
        $deleterequest->setEndPoint("api/v1/version");
        $deleterequest->setAcceptHeader("");
        $testData = array(
           "username" => "testuser",
           "password" => "testpassword"
        );
        $deleterequest->setJSONEncodedData($testData);

        $runok = $this->apiclient->httpDelete($deleterequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(2, $runok->getCode());
        $this->assertEquals(
            'Error Setting Accept Header in setCurlOption',
            $runok->getMessage()
        );
    }

    /**
     * Test if DELETE is with invalid URL
     *
     * Test that an error is returned if DELETE is called with an invalid URL
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access public
     */
    public function testDELETEInvalidURL()
    {
        $this->options->setBaseURL(BADURL);
        $apiclient = new APIClient($this->options);
        $deleterequest = new Request();
        $deleterequest->setEndPoint("api/v1/version");
        $arguments = array("users", "1");
        $deleterequest->setURLArguments($arguments);
        $runok = $apiclient->httpDelete($deleterequest);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(3, $runok->getCode());
        $this->assertContains(
            'Could not resolve host:',
            $runok->getMessage()
        );
    }
}
