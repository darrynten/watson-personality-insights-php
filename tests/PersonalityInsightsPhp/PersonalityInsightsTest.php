<?php

namespace DarrynTen\PersonalityInsightsPhp\Tests\PersonalityInsightsPhp;

use PHPUnit_Framework_TestCase;

use DarrynTen\PersonalityInsightsPhp\PersonalityInsights;

class PersonalityInsightsTest extends PHPUnit_Framework_TestCase
{
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
}
