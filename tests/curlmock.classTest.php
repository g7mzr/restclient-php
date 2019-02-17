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
class CurlInitTest extends TestCase
{

    use \phpmock\phpunit\PHPMock;

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


        $this->options->setProxyServer("localhost");
        $this->options->setProxyServerPort("8080");

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
     * testGETFailtoInitaliseCURL
     *
     * This test uses phpmock to cause curl_init to fail to initalise.
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testGETFailtoInitaliseCURL()
    {
        $curl_init = $this->getFunctionMock("\\g7mzr\\restclient\\http", "curl_init");
        $curl_init->expects($this->once())->willReturn(false);

        $request = new Request();
        $request->setEndPoint("api/v1/version");

        $runok = $this->apiclient->httpGet($request);
        $this->assertTrue(Common::isError($runok));
    }

    /**
     * testOptionsFailtoInitaliseCURL
     *
     * This test uses phpmock to cause curl_init to fail to initalise.
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testOPTIONSFailtoInitaliseCURL()
    {
        $curl_init = $this->getFunctionMock("\\g7mzr\\restclient\\http", "curl_init");
        $curl_init->expects($this->once())->willReturn(false);

        $request = new Request();
        $request->setEndPoint("api/v1/version");

        $runok = $this->apiclient->httpOptions($request);
        $this->assertTrue(Common::isError($runok));
    }

    /**
     * testHEADFailtoInitaliseCURL
     *
     * This test uses phpmock to cause curl_init to fail to initalise.
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testHEADFailtoInitaliseCURL()
    {
        $curl_init = $this->getFunctionMock("\\g7mzr\\restclient\\http", "curl_init");
        $curl_init->expects($this->once())->willReturn(false);

        $request = new Request();
        $request->setEndPoint("api/v1/version");

        $runok = $this->apiclient->httpHEAD($request);
        $this->assertTrue(Common::isError($runok));
    }

    /**
     * testPOSTFailtoInitaliseCURL
     *
     * This test uses phpmock to cause curl_init to fail to initalise.
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testPOSTFailtoInitaliseCURL()
    {
        $curl_init = $this->getFunctionMock("\\g7mzr\\restclient\\http", "curl_init");
        $curl_init->expects($this->once())->willReturn(false);

        $request = new Request();
        $request->setEndPoint("api/v1/version");

        $runok = $this->apiclient->httpPOST($request);
        $this->assertTrue(Common::isError($runok));
    }

    /**
     * testPUTFailtoInitaliseCURL
     *
     * This test uses phpmock to cause curl_init to fail to initalise.
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testPUTFailtoInitaliseCURL()
    {
        $curl_init = $this->getFunctionMock("\\g7mzr\\restclient\\http", "curl_init");
        $curl_init->expects($this->once())->willReturn(false);

        $request = new Request();
        $request->setEndPoint("api/v1/version");
        $request->setURLArguments(array("users", "1"));

        $runok = $this->apiclient->httpPut($request);
        $this->assertTrue(Common::isError($runok));
    }

    /**
     * testDELETEFailtoInitaliseCURL
     *
     * This test uses phpmock to cause curl_init to fail to initalise.
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testDELETEFailtoInitaliseCURL()
    {
        $curl_init = $this->getFunctionMock("\\g7mzr\\restclient\\http", "curl_init");
        $curl_init->expects($this->once())->willReturn(false);

        $request = new Request();
        $request->setEndPoint("api/v1/version");
        $request->setURLArguments(array("users", "1"));

        $runok = $this->apiclient->httpDelete($request);
        $this->assertTrue(Common::isError($runok));
    }


    /**
     * testGETFAILtoExecCURL
     *
     * This test uses phpmock to cause curl_exec to fail when adding proxy server
     * details to cURL Options and no proxy is available.
     *
     * @group unittest
     * @group error
     *
     * @return void
     *
     * @access protected
     */
    public function testGETFAILtoExecCURL()
    {
        $curl_init = $this->getFunctionMock("\\g7mzr\\restclient\\http", "curl_exec");
        $curl_init->expects($this->once())->willReturn(false);

        $request = new Request();
        $request->setEndPoint("api/v1/version");
        $request->setURLArguments(array("users", "1"));

        $runok = $this->apiclient->httpDelete($request);
        $this->assertTrue(Common::isError($runok));
        $this->assertEquals(3, $runok->getCode());
    }
}
