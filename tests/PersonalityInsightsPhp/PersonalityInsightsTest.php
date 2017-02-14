<?php

namespace DarrynTen\PersonalityInsightsPhp\Tests\PersonalityInsightsPhp;

use PHPUnit_Framework_TestCase;
use InterNations\Component\HttpMock\PHPUnit\HttpMockTrait;

use DarrynTen\PersonalityInsightsPhp\PersonalityInsights;
use DarrynTen\PersonalityInsightsPhp\CustomException;

class PersonalityInsightsTest extends PHPUnit_Framework_TestCase
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

    public function testConstruct()
    {
        $config = (array)json_decode(file_get_contents('credentials.json'));

        $instance = new PersonalityInsights($config);
        $this->assertInstanceOf(PersonalityInsights::class, $instance);
    }

    public function testSet()
    {
        $config = (array)json_decode(file_get_contents('credentials.json'));

        $instance = new PersonalityInsights($config);

        $this->assertEquals(true, $instance->config->cache);
        $instance->setCaching(false);
        $this->assertEquals(false, $instance->config->cache);
        $instance->setCaching(true);
    }

    public function testGetInsights()
    {
        if (getenv('DO_LIVE_API_TESTS') == "true") {
            $config = (array)json_decode(file_get_contents('credentials.json'));
            $instance = new PersonalityInsights($config);

            $instance->setText('');

            $insights = $instance->getInsights();
        }
    }

    public function testOptionals()
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
            'url' => 'http://localhost:8082/foo',
            'username' => 'xx',
            'password' => 'xx',
            'cache' => true,
            'raw_scores' => true,
            'consumption_preferences' => true,
            'version' => '2017-01-01',
        ];

        $instance = new PersonalityInsights($config);
        $this->assertInstanceOf(PersonalityInsights::class, $instance);

        $instance->setText('xxx');
        $this->assertEquals('xxx', $instance->originalText);

        $instance->config->getQueryUrl();

        $instance->getInsights();
    }

    public function testException()
    {
        $this->expectException(CustomException::class);

        $this->http->mock
            ->when()
                ->methodIs('POST')
                ->pathIs('/foo')
            ->then()
                ->body('{}')
            ->end();
        $this->http->setUp();

        $config = [
            'url' => 'http://localhost/foo',
            'username' => 'xx',
            'password' => 'xx',
            'cache' => true,
            'raw_scores' => true,
            'consumption_preferences' => true,
            'version' => '2017-01-01',
        ];

        $instance = new PersonalityInsights($config);
        $this->assertInstanceOf(PersonalityInsights::class, $instance);

        $instance->setText('xxx');
        $this->assertEquals('xxx', $instance->originalText);

        $instance->config->getQueryUrl();

        $instance->getInsights();
    }
}
