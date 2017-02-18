<?php

namespace DarrynTen\PersonalityInsightsPhp\Tests\PersonalityInsightsPhp;

use PHPUnit_Framework_TestCase;
use InterNations\Component\HttpMock\PHPUnit\HttpMockTrait;
use ReflectionClass;

use DarrynTen\PersonalityInsightsPhp\PersonalityInsights;
use DarrynTen\PersonalityInsightsPhp\ContentItem;
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
        $config = (array)json_decode(file_get_contents('tests/mocks/credentials.json'));

        $instance = new PersonalityInsights($config);
        $this->assertInstanceOf(PersonalityInsights::class, $instance);
    }

    public function testSet()
    {
        $config = (array)json_decode(file_get_contents('ctests/mocks/redentials.json'));

        $instance = new PersonalityInsights($config);

        $instance->config->setConsumptionPreferences(true);
        $instance->config->setRawScores(true);
        $instance->config->setCaching(true);
        $instance->config->setVersion('2017-01-01');
        $instance->config->setContentTypeHeader('application/json');
        $instance->config->setContentLanguageHeader('en');
        $instance->config->setAcceptHeader('application/json');
        $instance->config->setAcceptLanguageHeader('en');
        $instance->config->setOptOut(true);
        $instance->config->setCsvHeaders(false);
    }

    public function testSetExceptionsVersion()
    {
        $config = (array)json_decode(file_get_contents('tests/mocks/credentials.json'));

        $instance = new PersonalityInsights($config);

        $instance->config->setConsumptionPreferences('x');
        $instance->config->setRawScores('x');
        $instance->config->setOptOut('x');
        $instance->config->setCsvHeaders('x');

        $this->expectException(CustomException::class);
        $instance->config->setVersion('xxx');
    }

    public function testSetExceptionsContentTypeHeader()
    {
        $config = (array)json_decode(file_get_contents('tests/mocks/credentials.json'));

        $instance = new PersonalityInsights($config);

        $instance->config->setConsumptionPreferences('x');
        $instance->config->setRawScores('x');
        $instance->config->setOptOut('x');
        $instance->config->setCsvHeaders('x');

        $this->expectException(CustomException::class);
        $instance->config->setContentTypeHeader('xxx');
    }

    public function testSetExceptionsContentLanguageHeader()
    {
        $config = (array)json_decode(file_get_contents('tests/mocks/credentials.json'));

        $instance = new PersonalityInsights($config);

        $instance->config->setConsumptionPreferences('x');
        $instance->config->setRawScores('x');
        $instance->config->setOptOut('x');
        $instance->config->setCsvHeaders('x');

        $this->expectException(CustomException::class);
        $instance->config->setContentLanguageHeader('xxx');
    }

    public function testSetExceptionsContentAcceptHeader()
    {
        $config = (array)json_decode(file_get_contents('tests/mocks/credentials.json'));

        $instance = new PersonalityInsights($config);

        $instance->config->setConsumptionPreferences('x');
        $instance->config->setRawScores('x');
        $instance->config->setOptOut('x');
        $instance->config->setCsvHeaders('x');

        $this->expectException(CustomException::class);
        $instance->config->setAcceptHeader('xxx');
    }

    public function testSetExceptionsContentAcceptLanguageHeader()
    {
        $config = (array)json_decode(file_get_contents('tests/mocks/credentials.json'));

        $instance = new PersonalityInsights($config);

        $instance->config->setConsumptionPreferences('x');
        $instance->config->setRawScores('x');
        $instance->config->setOptOut('x');
        $instance->config->setCsvHeaders('x');

        $this->expectException(CustomException::class);
        $instance->config->setAcceptLanguageHeader('xxx');
    }

    public function testOptionals()
    {
        $text = file_get_contents('tests/mocks/textSample.txt');

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

        $instance->addText($text);

        $contentConfig = [
            'text' => $text
        ];

        $contentItem = new ContentItem($contentConfig);
        $contentItem->getContentItemJson();

        $instance->addNewContentItem($contentItem);


        $instance->contentItems->getContentItemsContainerJson();
        $instance->contentItems->getContentItemsContainerArray();

        $mockRequest = \Mockery::mock(
            'DarrynTen\PersonalityInsightsPhp\RequestHandler[request]',
            [
                $instance->config,
                $instance->contentItems,
            ]
        );

        $mockRequest->shouldReceive('request')
            ->once()
            ->andReturn();

        // Need to inject mock to a private property
        $reflection = new ReflectionClass($instance);
        $reflectedClient = $reflection->getProperty('request');
        $reflectedClient->setAccessible(true);
        $reflectedClient->setValue($instance, $mockRequest);

        $insights = $instance->getInsights();
        $instance->addText('xxx');

        $instance->config->getQueryUrl();

        $instance->getInsights();
    }

    public function testLiveCall()
    {
        if (getenv('DO_LIVE_API_TESTS') == "true") {
            $config = (array) json_decode(file_get_contents('credentials.json'));
            $config['cache'] = true;
            $config['raw_scores'] = true;
            $config['consumption_preferences'] = true;
            $config['version'] = '2017-01-01';

            $text = file_get_contents('tests/mocks/textSample.txt');

            $instance = new PersonalityInsights($config);

            $instance->addText($text);

            $contentConfig = [
                'text' => $text
            ];

            $contentItem = new ContentItem($contentConfig);

            $instance->addNewContentItem($contentItem);

            $insights = $instance->getInsights();
        }
    }
}
