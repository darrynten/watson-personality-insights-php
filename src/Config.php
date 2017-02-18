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
     * The version of the Watson API to use
     *
     * @var string $apiVersion
     */
    private $apiVersion = 'v3';

    /**
     * The common base URL
     *
     * @var string $baseUrl
     */
    private $baseUrl = 'https://gateway.watsonplatform.net';

    /**
     * The API URL namespace
     *
     * @var string $urlNamespace
     */
    private $apiNamespace = 'personality-insights/api';

    /**
     * The Auth namespace
     *
     * @var string $authNamespace
     */
    private $authNamespace = 'authorization/api';

    /**
     * The version of the auth service
     *
     * @var string $authVersion
     */
    private $authVersion = 'v1';

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
     * TODO csv
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
     * Whether or not to allow IBM to keep a copy of your text
     *
     * Default is OFF to protect privacy
     *
     * You must explicitly enable this if you wish to help Warson
     * learn from your text
     *
     * @var boolean $optOutOfLogging
     */
    public $optOutOfLogging = true;

    /**
     * Construct the config object
     *
     * @param array $config An array of configuration options
     */
    public function __construct(array $config)
    {
        // Throw exceptions on essentials
        if (empty($config['username'])) {
            throw new CustomException('Missing Watson Personality API Username');
        } else {
            $this->username = (string) $config['username'];
        }

        if (empty($config['password'])) {
            throw new CustomException('Missing Watson Personality API Password');
        } else {
            $this->password = (string) $config['password'];
        }

        // optionals
        if (!empty($config['cache'])) {
            $this->cache = (bool) $config['cache'];
        }

        // I've stuck with the snake case that IBM use in their queries
        if (!empty($config['raw_scores'])) {
            $this->rawScores = (bool) $config['raw_scores'];
        }

        if (!empty($config['consumption_preferences'])) {
            $this->includeConsumption = (bool) $config['consumption_preferences'];
        }

        if (!empty($config['version'])) {
            $this->version = (string) $config['version'];
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
          'consumption_preferences' => (string) $this->includeConsumption ? 'true' : 'false',
          'version' => $this->version,
        ];

        return http_build_query($queryParams);
    }

    /**
     * Gets the Authentication URL
     *
     * @return string
     */
    public function getAuthUrl()
    {
        $return = $this->baseUrl .
          '/' . $this->authNamespace .
          '/' . $this->authVersion .
          '/token?url=' . $this->baseUrl . '/' . $this->apiNamespace;

        return $return;
    }

    /**
     * Gets the Authentication header
     *
     * @return array
     */
    public function getAuthHeader()
    {
        return [
            'auth' => [
                $this->username,
                $this->password,
            ],
        ];
    }

    /**
     * Gets the API URL
     *
     * @return string
     */
    public function getApiUrl()
    {
        $return = $this->baseUrl .
          '/' . $this->apiNamespace .
          '/' . $this->apiVersion .
          '/profile?' .
          $this->getPersonalityInsightsQueryVariables();

        return $return;
    }

    /**
     * Set the consumption preference flag
     *
     * @var boolean $flag Whether or not to include consumption prefereces
     */
    public function setConsumptionPreferences(bool $flag)
    {
        $this->includeConsumption = $flag;
    }

    /**
     * Set the raw scores flag
     *
     * @var boolean $flag Whether or not to use raw scores
     */
    public function setRawScores(bool $flag)
    {
        $this->rawScores = $flag;
    }

    /**
     * Set the caching flag
     *
     * @var boolean $flag Whether or not to use raw scores
     */
    public function setCaching(bool $flag)
    {
        $this->cache = $flag;
    }

    /**
     * Set the version if it is valid
     *
     * @var string $version
     */
    public function setVersion(string $version)
    {
        if (Validation::isValidVersionRegex($version)) {
            $this->version = $version;
        } else {
            throw new CustomException('Malformed version');
        }
    }

    /**
     * Set the content type header
     *
     * @var string $header
     */
    public function setContentTypeHeader(string $header)
    {
        if (Validation::isValidContentType($header)) {
            $this->contentTypeHeader = $header;
        } else {
            throw new CustomException('Invalid content type');
        }
    }

    /**
     * Set the content language header
     *
     * @var string $header
     */
    public function setContentLanguageHeader(string $header)
    {
        if (Validation::isValidContentLanguage($header)) {
            $this->contentLanguageHeader = $header;
        } else {
            throw new CustomException('Invalid language');
        }
    }

    /**
     * Set accept  header
     *
     * @var string $header The accept language header
     */
    public function setAcceptHeader(string $header)
    {
        if (Validation::isValidAcceptType($header)) {
            $this->acceptHeader = $header;
        } else {
            throw new CustomException('Invalid accept type');
        }
    }

    /**
     * Set accept language header
     *
     * @var string $header The accept language header
     */
    public function setAcceptLanguageHeader(string $header)
    {
        if (Validation::isValidAcceptLanguage($header)) {
            $this->acceptLanguageHeader = $header;
        } else {
            throw new CustomException('Invalid accept language');
        }
    }

    /**
     * Set opt out
     *
     * @var boolean $flag No logging
     */
    public function setOptOut(bool $flag)
    {
        $this->optOutOfLogging = $flag;
    }

    /**
     * Set csv headers
     *
     * TODO csv
     *
     * @var boolean $flag Use csv headers
     */
    public function setCsvHeaders(bool $flag)
    {
        $this->csvHeaders = $flag;
    }
}
