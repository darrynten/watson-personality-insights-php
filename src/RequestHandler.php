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
     * The PersonalityInsights url
     *
     * @var string $url
     */
    private $url = 'https://gateway.watsonplatform.net/personality-insights/api/v3/profile';

    /**
     * Personality Insights Username
     *
     * @var string $username
     */
    private $username;

    /**
     * Personality Insights Password
     *
     * @var string $password
     */
    private $password;

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
    public function __construct($config)
    {
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->url = $config['url'];

        $this->client = new Client();
    }

    /**
     * Makes a request to Personality Insights
     *
     * @return object
     *
     * @throws PersonalityInsightsApiException
     */
    public function request(array $options = [], array $parameters = [])
    {
        try {
            $response = $this->client->request('POST', $this->url, $options);
            return json_decode($response->getBody());
        } catch (RequestException $exception) {
            $message = $exception->getMessage();

            throw new CustomException($message, $exception->getCode(), $exception);
        }
    }
}
