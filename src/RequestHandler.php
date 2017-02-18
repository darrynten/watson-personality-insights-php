<?php
/**
 * Watson Personality Insights Library
 *
 * @category Library
 * @package  PersonalityInsightsPhp
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/watson-personality-insights-php/LICENSE>
 * @link     https://github.com/darrynten/watson-personality-insights-php
 */

namespace DarrynTen\PersonalityInsightsPhp;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

/**
 * Request Handler Class
 *
 * @category Library
 * @package  PersonalityInsights
 * @author   Darryn Ten <darrynten@github.com>
 */
class RequestHandler
{
    /**
     * GuzzleHttp Client
     *
     * @var Client $client
     */
    private $client;

    /**
     * The returned base64 encoded auth token
     *
     * @var string $token
     */
    private $token;

    /**
     * The expire time of the token
     *
     * @var \DateTime $tokenExpireTime
     */
    private $tokenExpireTime;

    /**
     * HTTP Headers
     *
     * @var array $headers
     */
    private $headers = [];

    /**
     * Request Handler constructor
     *
     * @param string $username The username
     * @param string $password The password
     */
    public function __construct()
    {
        $this->tokenExpireTime = new \DateTime();

        $this->client = new Client();
    }

    /**
     * Make request to Watson Auth API for the new token
     */
    private function requestToken()
    {
        $tokenResponse = $this->client->request(
            'GET',
            $this->config->getAuthUrl(),
            $this->config->getAuthHeader()
        );


        $this->token = $tokenResponse->getBody()->getContents();

        $this->tokenExpireTime->modify(
            sprintf('+%s seconds', 3600)
        );
    }

    /**
     * Get token for Watson
     *
     * @return string
     */
    private function getAuthToken()
    {
        // Generate a new token if current is expired or empty
        if (!$this->token || new \DateTime() > $this->tokenExpireTime) {
            $this->requestToken();
        }

        return $this->token;
    }

    /**
     * Makes a request to Personality Insights
     *
     * @param \Config $config The client config
     * @param \ContentItems $contentItems The collection of content
     *
     * @return object
     *
     * @throws PersonalityInsightsApiException
     */
    public function request(Config $config, ContentItems $contentItems)
    {
        $this->config = $config;

        $options = [
            'headers' => [
                'X-Watson-Authorization-Token' => $this->getAuthToken(),
                'X-Watson-Learning-Opt-Out' => $this->config->optOutOfLogging,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Accept-Language' => 'en'
            ],
            'body' => $contentItems->getContentItemsContainerJson()
        ];

        $response = $this->client->request(
            'POST',
            $config->getApiUrl(),
            $options
        );
        return json_decode($response->getBody());
    }
}
