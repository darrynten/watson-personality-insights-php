<?php

namespace DarrynTen\PersonalityInsightsPhp;

/**
 * Watson Personality Insights ContentItem Collection Model
 *
 * @category Model
 * @package  PersonalityInsightsPhp
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/watson-personality-insights-php/LICENSE>
 * @link     https://github.com/darrynten/watson-personality-insights-php
 */
class ContentItems
{
    /**
     * Content Item Collection
     *
     * Container of content items that need to be analyzed.
     * The service supports up to 20Mb of content for all items combined.
     *
     * @var string $collection
     */
    private $collection;

    /**
     * Construct
     *
     * @return object
     */
    public function __construct()
    {
        $this->collection = [];
    }

    /**
     * Get the json representation of the collection
     *
     * @return array
     */
    public function getContentItemsContainerArray()
    {
        return [
            'contentItems' => $this->collection
        ];
    }

    /**
     * Get the json representation of the collection
     *
     * @return string
     */
    public function getContentItemsContainerJson()
    {
        return json_encode($this->getContentItemsContainerArray());
    }

    /**
     * Add a content item to the collection
     *
     * @param ContentItem  $contentItem
     */
    public function addContentItemToCollection(ContentItem $contentItem)
    {
        $this->collection[] = $contentItem->getContentItemArray();
    }
}
