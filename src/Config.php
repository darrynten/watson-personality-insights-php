<?php

namespace DarrynTen\PersonalityInsightsPhp;

use Psr\Cache\CacheItemPoolInterface;

/**
 * PersonalityInsights Config
 *
 * @category Configuration
 * @package  PersonalityInsightsPhp
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/watson-personality-insights-php/LICENSE>
 * @link     https://github.com/darrynten/watson-personality-insights-php
 */
class Config
{
    /**
     * The project ID
     *
     * @var string $projectId
     */
    private $projectId;

    /**
     * Whether or not to use caching.
     *
     * The default is true as this is a good idea.
     *
     * @var boolean $cache
     */
    public $cache = true;

    /**
     * Cheapskate mode - trim text at 1000 chars
     *
     * @var boolean $cheapskate
     */
    public $cheapskate = true;

    /**
     * The scopes
     *
     * @var array $scopes
     */
    private $scopes;

    /**
     * Construct the config object
     *
     * @param array $config An array of configuration options
     */
    public function __construct($config)
    {
        // Throw exceptions on essentials
        if (!isset($config['projectId']) || empty($config['projectId'])) {
            throw new CustomException('Missing Watson Personality Insights Project ID');
        } else {
            $this->projectId = (string)$config['projectId'];
        }

        // optionals
        if (isset($config['cheapskate'])) {
            $this->cheapskate = (bool)$config['cheapskate'];
        }

        if (isset($config['cache']) && !empty($config['cache'])) {
            $this->cache = (bool)$config['cache'];
        }

        if (isset($config['scopes']) && !empty($config['scopes'])) {
            $this->scopes = $config['scopes'];
        }
    }

    /**
     * Retrieves the expected config for the Personality Insights API
     *
     * @return array
     */
    public function getPersonalityInsightsConfig()
    {
        $config = [
            'projectId' => $this->projectId
        ];

        if ($this->scopes) {
            $config['scopes'] = $this->scopes;
        }

        return $config;
    }
}
