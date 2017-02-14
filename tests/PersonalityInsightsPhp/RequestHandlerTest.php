<?php

namespace DarrynTen\PersonalityInsightsPhp\Tests\PersonalityInsightsPhp;

use DarrynTen\PersonalityInsightsPhp\RequestHandler;
use InterNations\Component\HttpMock\PHPUnit\HttpMockTrait;

class RequestHandlerTest extends \PHPUnit_Framework_TestCase
{
    use HttpMockTrait;

    public static function setUpBeforeClass()
    {
        static::setUpHttpMockBeforeClass('8082', 'localhost');
    }

    public static function tearDownAfterClass()
    {
        static::tearDownHttpMockAfterClass();
    }

    public function setUp()
    {
        $this->setUpHttpMock();
    }

    public function tearDown()
    {
        $this->tearDownHttpMock();
    }

    public function testInstanceOf()
    {
        $request = new RequestHandler([]);
        $this->assertInstanceOf(RequestHandler::class, $request);
    }

    public function testRequest()
    {
        $this->http->mock
            ->when()
                ->methodIs('POST')
                ->pathIs('/foo')
            ->then()
                ->body('{}')
            ->end();
        $this->http->setUp();

        $config = [
            'username' => 'x',
            'password' => 'x',
            'url' => 'http://localhost:8082/foo',
        ];

        $request = new RequestHandler($config);

        $this->assertEquals(json_decode('{}'), $request->request([], []));
    }

    public function testRequestEmptyResponse()
    {
        $this->http->mock
            ->when()
                ->methodIs('POST')
                ->pathIs('/foo')
            ->then()
                ->body('{ value: 1 }')
            ->end();
        $this->http->setUp();

        $config = [
            'username' => 'x',
            'password' => 'x',
            'url' => 'http://localhost:8082/foo',
        ];

        $request = new RequestHandler($config);

        $this->assertEquals(
            json_decode('{ body: { code: 1 } }'),
            $request->request([], [])
        );
    }
}
