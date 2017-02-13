<?php

namespace DarrynTen\PersonalityInsightsPhp\Tests\PersonalityInsightsPhp;

use PHPUnit_Framework_TestCase;

use DarrynTen\PersonalityInsightsPhp\PersonalityInsights;

class PersonalityInsightsTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $config = [
            'projectId' => 'project-id'
        ];

        $instance = new PersonalityInsights($config);
        $this->assertInstanceOf(PersonalityInsights::class, $instance);
    }

    public function testSet()
    {
        $config = [
            'projectId' => 'project-id',
            'cheapskate' => true,
            'cache' => true,
            'scopes' => ['scope'],
        ];

        $instance = new PersonalityInsights($config);

        var_dump($instance);

        $this->assertEquals(true, $instance->config->cheapskate);
        $instance->setCheapskate(false);
        $this->assertEquals(false, $instance->config->cheapskate);
        $instance->setCheapskate(true);

        $this->assertEquals(true, $instance->config->cache);
        $instance->setCache(false);
        $this->assertEquals(false, $instance->config->cache);
        $instance->setCache(true);
    }

    public function testGetInsights()
    {
        if (getenv('DO_LIVE_API_TESTS') == "true") {
            $config = [
                'projectId' => 'project-id',
                'cheapskate' => true,
                'cache' => true,
            ];

            $instance = new PersonalityInsights($config);

            $instance->setText('A duck and a cat in a field at night');

            $insights = $instance->getEntities();
        }
    }
}
