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
     * @var string $text
     */
    public $text;

    /**
     * Construct
     *
     * Bootstraps the config and the cache, then loads the request handler
     *
     * @param array $config Configuration options
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);
        $this->cache = new AnyCache();

        $this->contentItems = new ContentItems();

        $this->request = new RequestHandler($config);
    }

    /**
     * Add some plain text
     *
     * This is a helper to add a content item just via a string and
     * it generates and adds a \ContentItem object to its collection.
     *
     * @param string $text
     */
    public function addText(string $text)
    {
        $contentConfig = [
            'text' => $text
        ];

        $contentItem = new ContentItem($contentConfig);

        $this->contentItems->addContentItemToCollection($contentItem);
    }

    /**
     * Add a new proper content item to the collection
     *
     * @param ContentItem $contentItem
     */
    public function addNewContentItem(ContentItem $contentItem)
    {
        $this->contentItems->addContentItemToCollection($contentItem);
    }

    /**
     * TODO modify and remove
     */

    /**
     * Get the entity analysis
     *
     * @return mixed
     */
    public function getInsights()
    {
        $cacheKey = sprintf(
            '__watson_personality_insights_%s_',
            md5(serialize($this->contentItems))
        );

        if (!$result = unserialize($this->cache->get($cacheKey)) || !$this->config->cache) {
            $result = $this->request->request($this->config, $this->contentItems);
            $this->cache->put($cacheKey, serialize($result), 9999999);
        }

        return $result;
    }
}
