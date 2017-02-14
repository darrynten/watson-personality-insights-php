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
     * CSV Headers
     *
     * If true, column labels are returned with a CSV response; if false
     * (the default), they are not. Applies only when the Accept header
     * is set to text/csv.
     *
     * @var string $csvHeaders
     */
    private $csvHeaders = false;

    /**
     * Whether or not to use caching.
     *
     * The default is true as this is a good idea.
     *
     * @var boolean $cache
     */
    public $cache = true;

    /**
     * Request header options
     */

    /**
     * Content-Type header
     *
     * The content type of the request: plain text, HTML, or JSON
     * (default) - Per the JSON specification, the default character
     * encoding for JSON content is effectively always UTF-8; per the
     * HTTP specification, the default encoding for plain text and HTML
     * is ISO-8859-1 (effectively, the ASCII character set). When
     * specifying a content type of plain text or HTML, include the
     * charset parameter to indicate the character encoding of the input
     * text, for example, Content-Type: text/plain;charset=utf-8.
     *
     * application/json is the default which differs from the docs
     *
     * @link https://watson-api-explorer.mybluemix.net/apis/personality-insights-v3
     *
     * @var string $contentTypeHeader
     */
    private $contentTypeHeader = 'application/json';

    /**
     * Content-Language header
     *
     * Currently `en` (default), `ar`, `es`, `ja` (Feb 2017)
     *
     * The language of the input text for the request: Arabic, English,
     * Spanish, or Japanese. Regional variants are treated as their
     * parent language; for example, en-US is interpreted as en. The
     * effect of the Content-Language header depends on the Content-Type
     * header. When Content-Type is text/plain or text/html,
     * Content-Language is the only way to specify the language. When
     * Content-Type is application/json, Content-Language overrides a
     * language specified with the language parameter of a ContentItem
     * object, and content items that specify a different language are
     * ignored; omit this header to base the language on the
     * specification of the content items. You can specify any
     * combination of languages for Content-Language and Accept-Language.
     *
     * @var string $contentLanguageHeader
     */
    private $contentLanguageHeader = 'en';

    /**
     * Accept header
     *
     * Either `application/json` or `text/csv`
     *
     * The desired content type of the response: JSON (the default) or
     * CSV. CSV output includes a fixed number of columns and optional
     * headers.
     *
     * @var string $acceptHeader
     */
    private $acceptHeader = 'application/json';

    /**
     * Accept-Language header
     *
     * The desired language of the response. For two-character arguments,
     * regional variants are treated as their parent language; for
     * example, en-US is interpreted as en. You can specify any
     * combination of languages for the input and response content.
     *
     * @var string $acceptLanguageHeader
     */
    private $acceptLanguageHeader;

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
