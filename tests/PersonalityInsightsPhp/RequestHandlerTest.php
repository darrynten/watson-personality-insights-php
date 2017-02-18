<?php

namespace DarrynTen\PersonalityInsightsPhp\Tests\PersonalityInsightsPhp;

use DarrynTen\PersonalityInsightsPhp\PersonalityInsights;
use DarrynTen\PersonalityInsightsPhp\ContentItem;
use DarrynTen\PersonalityInsightsPhp\Config;
use DarrynTen\PersonalityInsightsPhp\RequestHandler;
use DarrynTen\PersonalityInsightsPhp\CustomException;
use InterNations\Component\HttpMock\PHPUnit\HttpMockTrait;
use ReflectionClass;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

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
        $data = '{\'key\':\'data\'}';

        $this->http->mock
            ->when()
                ->methodIs('POST')
                ->pathIs('/foo')
            ->then()
                ->body($data)
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

        $text = 'xxx';
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

        $configObject = new Config($config);
        $request = new RequestHandler($configObject);


        $options = [
            'headers' => [
                'X-Watson-Authorization-Token' => 'xxx',
                'Content-Type' => 'application/json; charset=utf-8',
                'Accept' => 'application/json',
                'Accept-Language' => 'en'
            ],
            'body' => $instance->contentItems->getContentItemsContainerJson()
        ];


        $mockClient = \Mockery::mock(
            'Client'
        );

        $localClient = new Client();

        $localResult = $localClient->request(
            'POST',
            'http://localhost:8082/foo',
            []
        );

        $mockClient->shouldReceive('request')
            ->once()
            ->andReturn($localResult);

        // Need to inject mock to a private property
        $reflection = new ReflectionClass($request);
        $reflectedClient = $reflection->getProperty('client');
        $reflectedClient->setAccessible(true);
        $reflectedClient->setValue($request, $mockClient);

        $request->request($configObject, $instance->contentItems);
    }
}
