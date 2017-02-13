<?php

namespace DarrynTen\PersonalityInsightsPhp;

use DarrynTen\AnyCache\AnyCache;
use FindBrok\WatsonBridge\Bridge;

/**
 * Watson Personality Insights Client
 *
 * @category Library
 * @package  PersonalityInsightsPhp
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/watson-personality-insights-php/LICENSE>
 * @link     https://github.com/darrynten/watson-personality-insights-php
 */
class PersonalityInsights
{
    /**
     * Hold the config option
     *
     * @var Config $config
     */
    public $config;

    /**
     * Keeps a copy of the personality client
     *
     * @var object $personalityClient
     */
    private $personalityClient;

    /**
     * The local cache
     *
     * @var AnyCache $cache
     */
    private $cache;

    /**
     * The text to perform actions on
     *
     * @var string $originalText
     */
    public $originalText;

    /**
     * Construct
     *
     * Bootstraps the config and the cache, then loads the client
     *
     * @param array $config Configuration options
     */
    public function __construct($config)
    {
        $this->config = new Config($config);
        $this->cache = new AnyCache();

        $this->personalityClient = new Bridge($config['username'], $config['password'], $config['url'] . '/v3/profile');
    }

    /**
     * Set the desired text
     *
     * @param string $text The text to be analysed
     *
     * @return void
     */
    public function setText($text)
    {
        $this->originalText = $text;
    }

    /**
     * Get the entity analysis
     *
     * @return mixed
     */
    public function getInsights()
    {
        // $cacheKey = '__watson_personality_insights_' .
            // md5($this->originalText) . '_';

        // if (!$result = unserialize($this->cache->get($cacheKey))) {
            $result = $this->personalityClient->post($this->config->getQueryUrl(), json_encode($items), 'json');
            // $this->cache->put($cacheKey, serialize($result), 9999999);
        // }

        return $result;
    }

    /**
     * Enable and disable internal cache
     *
     * @param boolean $value The state
     *
     * @return void
     */
    public function setCaching($value)
    {
        $this->config->cache = (bool)$value;
    }
}
