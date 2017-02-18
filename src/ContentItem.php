<?php

namespace DarrynTen\PersonalityInsightsPhp;

/**
 * Watson Personality Insights Content Item
 *
 * @category Model
 * @package  PersonalityInsightsPhp
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/watson-personality-insights-php/LICENSE>
 * @link     https://github.com/darrynten/watson-personality-insights-php
 */
class ContentItem
{
    /**
     * Content
     *
     * Content that is to be analyzed. The service supports up to 20MB
     * of content for all items combined
     *
     * @var string $content
     */
    private $content;

    /**
     * ID (optional)
     *
     * Unique identifier for this content item
     *
     * @var string $id
     */
    private $id;

    /**
     * Created (optional)
     *
     * Timestamp that identifies when this content was created. Specify
     * a value in milliseconds since the UNIX Epoch (January 1, 1970, at
     * 0:00 UTC). Required only for results that include temporal
     * behavior data
     *
     * @var string $created
     */
    private $created;

    /**
     * Updated (optional)
     *
     * Timestamp that identifies when this content was last updated.
     * pecify a value in milliseconds since the UNIX Epoch (January 1,
     * 1970, at 0:00 UTC). Required only for results that include
     * temporal behavior data.
     *
     * @var string $updated
     */
    private $updated;

    /**
     * Content type (optional)
     *
     * MIME type of the content. The default is plain text. The tags are
     * stripped from HTML content before it is analyzed; plain text is
     * processed as submitted. = ['text/plain', 'text/html']
     *
     * @var string $contenttype
     */
    private $contenttype;

    /**
     * Language (optional)
     *
     * Language identifier (two-letter ISO 639-1 identifier) for the
     * language of the content item. The default is en (English).
     * Regional variants are treated as their parent language; for
     * example, en-US is interpreted as en. A language specified with
     * the Content-Type header overrides the value of this parameter;
     * any content items that specify a different language are ignored.
     * Omit the Content-Type header to base the language on the most
     * prevalent specification among the content items; again, content
     * items that specify a different language are ignored. You can
     * specify any combination of languages for the input and response
     * content. = ['ar', 'en', 'es', 'ja']
     *
     * @var string $language
     */
    private $language;

    /**
     * Parent ID (optional)
     *
     * Unique ID of the parent content item for this item. Used to
     * identify hierarchical relationships between posts/replies,
     * messages/replies, and so on.
     *
     * @var string $parentid
     */
    private $parentid;

    /**
     * Reply (optional)
     *
     * Indicates whether this content item is a reply to another content
     * item.
     *
     * @var string $reply
     */
    private $reply;

    /**
     * Forward (optional)
     *
     * Indicates whether this content item is a forwarded/copied version
     * of another content item.
     *
     * @var string $forward
     */
    private $forward;

    /**
     * Construct
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->content = $config['text'];
        $this->id = $config['id'] || md5($config['text']);
        $this->created = !empty($config['created']) ? $config['created'] : 0;
        $this->updated = !empty($config['updated']) ? $config['updated'] : 0;
        $this->contenttype = !empty($config['contenttype']) ? $config['contenttype'] : 'text/plain';
        $this->language = !empty($config['language']) ? $config['language'] : 'en';
        $this->parentid = !empty($config['parentid']) ? $config['parentid'] :  null;
        $this->reply= !empty($config['reply']) ? $config['reply'] : false;
        $this->forward = !empty($config['forward']) ? $config['forward'] : false;
    }

    /**
     * Returns an representation of the content item
     *
     * @return array
     */
    public function getContentItemArray()
    {
        return [
            'content' => $this->content,
            'id' => $this->id,
            'created' => $this->created,
            'updated' => $this->updated,
            'contenttype' => $this->contenttype,
            'language' => $this->language,
            'parentid' => $this->parentid,
            'reply' => $this->reply,
            'forward' => $thos->forward,
        ];
    }

    /**
     * Returns a JSON representation of the content item
     *
     * @return string
     */
    public function getContentItemJson()
    {
        return json_encode($this->getContentItemArray());
    }
}
