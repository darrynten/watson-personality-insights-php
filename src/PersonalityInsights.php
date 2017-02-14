<?php

namespace DarrynTen\PersonalityInsightsPhp;

use DarrynTen\AnyCache\AnyCache;

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
     * Request handler
     *
     * @var RequestHandler $request
     */
    private $request;

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
     * Bootstraps the config and the cache, then loads the request handler
     *
     * @param array $config Configuration options
     */
    public function __construct($config)
    {
        $this->config = new Config($config);
        $this->cache = new AnyCache();

        $this->request = new RequestHandler($config);
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
        $cacheKey = '__watson_personality_insights_' .
            md5($this->originalText) . '_';

        // Temporary
        //
        // if (!$result = unserialize($this->cache->get($cacheKey))) {
            $result = $this->request->request([], []);
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
