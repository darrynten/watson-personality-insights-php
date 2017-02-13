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
     * The API endpoint
     *
     * @var string $endpoint
     */
    private $url;

    /**
     * Username for the platform
     *
     * @var string $username
     */
    private $username;

    /**
     * Password for the service
     *
     * @var string $password
     */
    private $password;

    /**
     * Include raw scores
     *
     * If true, a raw score in addition to a normalized percentile
     * is returned for each characteristic; raw scores are not
     * compared with a sample population. If false (the default),
     * only normalized percentiles are returned.
     *
     * @var boolean $rawScores
     */
    private $rawScores = false;

    /**
     * Include consumption preferences
     *
     * If true, information about consumption preferences is returned
     * with the results; if false (the default), the response does
     * not include the information.
     *
     * @var boolean $includeConsumption
     */
    private $includeConsumption = false;

    /**
     * Version
     *
     * The requested version of the response as a date in the format
     * YYYY-MM-DD
     *
     * If you specify a date that is earlier than the initial release
     * of version 3, the service returns the response format for that
     * first version. If you specify a date that is in the future or
     * otherwise later than the most recent version, the service
     * returns the response format for the latest version.
     *
     * @var string $version
     */
    private $version;

    /**
     * Whether or not to use caching.
     *
     * The default is true as this is a good idea.
     *
     * @var boolean $cache
     */
    public $cache = true;

    /**
     * Construct the config object
     *
     * @param array $config An array of configuration options
     */
    public function __construct($config)
    {
        // Throw exceptions on essentials
        if (!isset($config['url']) || empty($config['url'])) {
            throw new CustomException('Missing Watson Personality API Endpoint');
        } else {
            $this->url = (string)$config['url'];
        }

        if (!isset($config['username']) || empty($config['username'])) {
            throw new CustomException('Missing Watson Personality API Username');
        } else {
            $this->username = (string)$config['username'];
        }

        if (!isset($config['password']) || empty($config['password'])) {
            throw new CustomException('Missing Watson Personality API Password');
        } else {
            $this->password = (string)$config['password'];
        }

        // optionals
        if (isset($config['cache']) && !empty($config['cache'])) {
            $this->cache = (bool)$config['cache'];
        }

        // I've stuck with the snake case that IBM use in their queries
        if (isset($config['raw_scores']) && !empty($config['raw_scores'])) {
            $this->rawScores = (bool)$config['raw_scores'];
        }

        if (isset($config['consumption_preferences']) && !empty($config['consumption_preferences'])) {
            $this->includeConsumption = (bool)$config['consumption_preferences'];
        }

        if (isset($config['version']) && !empty($config['version'])) {
            $this->version = (string)$config['version'];
        } else {
            $this->version = date('Y-m-d');
        }
    }

    /**
     * Retrieves the expected config for the Personality Insights API
     *
     * @return array
     */
    private function getPersonalityInsightsQueryVariables()
    {
        $queryParams = [
          'raw_scores' => $this->rawScores ? 'true' : 'false',
          'consumption_preferences' => (string)$this->includeConsumption ? 'true' : 'false',
          'version' => $this->version,
        ];

        return http_build_query($queryParams);
    }

    /**
     * Returns the prepared API endpoint URL
     *
     * @return string
     */
    public function getQueryUrl()
    {
        return $this->url . '/v3/profile?' . $this->getPersonalityInsightsQueryVariables();
    }
}
