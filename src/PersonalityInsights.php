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

        $this->personalityClient = new Bridge('username', 'password', 'http://x.x');


        // $this->personalityClient = new PersonalityInsightsClient(
            // $this->config->getPersonalityInsightsConfig()
        // );
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
        $this->checkCheapskate();
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

        if (!$result = unserialize($this->cache->get($cacheKey))) {
            $result = $this->personalityClient->getInsights($this->originalText);
            $this->cache->put($cacheKey, serialize($result), 9999999);
        }

        return $result;
    }

    /**
     * After 1000 characters ibm charges for a new evaluation
     *
     * Set `cheapskate` in your config to false to turn this off
     *
     * Default is on to save cash
     *
     * @throws CustomException
     * @return void
     */
    private function checkCheapskate()
    {
        if (strlen($this->originalText) > 999) {
            if ($this->config->cheapskate === true) {
                throw new CustomException(
                    'Text too long. 1000+
                    Characters incurrs additional charges. You can set
                    `cheapskate` to false in config to disable this
                    guard. Additional charges per 1000 Characters.'
                );
            }
        }
    }

    /**
     * Enable and disable cheapskate mode (trimming @ 1000 chars)
     *
     * @param boolean $value The state
     *
     * @return void
     */
    public function setCheapskate($value)
    {
        $this->config->cheapskate = (bool)$value;
    }

    /**
     * Enable and disable internal cache
     *
     * @param boolean $value The state
     *
     * @return void
     */
    public function setCache($value)
    {
        $this->config->cache = (bool)$value;
    }
}
