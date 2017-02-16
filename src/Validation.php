<?php
/**
 * PersonalityInsightsPhp Validation
 *
 * @category Validation
 * @package  PersonalityInsightsPhp
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/watson-personality-insights-php/LICENSE>
 * @link     https://github.com/darrynten/watson-personality-insights-php
 */

namespace DarrynTen\PersonalityInsightsPhp;

class Validation
{
    /**
     * The valid content types
     *
     * Plain text, html, or json
     *
     * @var array $validContentTypes
     */
    private static $validContentTypes = [
        'application/json',
        'text/html',
        'text/plain',
    ];

    /**
     * Valid content languages
     *
     * en, ar, ja and es
     *
     * @var array $validContentLanguages
     */
    private static $validContentLanguages = [
        'en',
        'ar',
        'ja',
        'es',
    ];

    /**
     * Valid accept types
     *
     * json and csv
     *
     * @var array $validAcceptTypes
     */
    private static $validAcceptTypes = [
        'application/json',
        'text/csv',
    ];

    /**
     * Valid accept languages
     *
     * @var array $validAcceptLanguages
     */
    private static $validAcceptLanguages = [
        'en',
        'ar',
        'de',
        'es',
        'fr',
        'it',
        'ja',
        'ko',
        'pt-br',
        'zh-cn',
        'zh-tw',
    ];

    /**
     * A valid ISO language regex (en)
     *
     * @var string $validISOLanguageRegex Regex for 2 characters
     */
    private static $validISOLanguageRegex = '/^[a-z]{2}$/';

    /**
     * A valid BCP-47 language regex (en-ZA)
     *
     * @var string $validBCP47LanguageRegex Regex for two lowecase, dash, 2 uppercase
     */
    private static $validBCP47LanguageRegex = '/^[a-z]{2}\-[A-Z]{2}$/';

    /**
     * A regex for the date format of the version YYYY-MM-DD
     *
     * @var string $validVersionRegex
     */
    private static $validVersionRegex = '/^[1-2]{1}[0-9]{3}\-[0-1]{1}[0-9]{1}\-[0-3]{1}[0-9]{1}$/';

    /**
     * Check to see if the version string is valid
     *
     * @var string $version
     *
     * @return boolean
     */
    public static function isValidVersionRegex($version)
    {
        return (bool) preg_match(self::$validVersionRegex, $version);
    }

    /**
     * Check if a string is a possible language string.
     *
     * Not the best but better than nothing. Can be expanded
     * upon.
     *
     * Accepts ISO (en, es, de) and BCP-47 (en-ZA, en-GB)
     *
     * @param string $language The language to check
     *
     * @return boolean
     */
    public static function isValidLanguageRegex($language)
    {
        $match = false;

        if (preg_match(self::$validISOLanguageRegex, $language)) {
            $match = true;
        }

        if (preg_match(self::$validBCP47LanguageRegex, $language)) {
            $match = true;
        }

        return $match;
    }

    /**
     * Check if valid content type
     *
     * @return boolean
     */
    public static function isValidContentType($contentType)
    {
        return in_array($contentType, self::$validContentTypes);
    }

    /**
     * Check if valid content language
     *
     * @return boolean
     */
    public static function isValidContentLanguage($language)
    {
        return in_array($language, self::$validContentLanguages);
    }

    /**
     * Check if valid accept type
     *
     * @return boolean
     */
    public static function isValidAcceptType($type)
    {
        return in_array($type, self::$validAcceptTypes);
    }

    /**
     * Check if valid accept language
     *
     * @return boolean
     */
    public static function isValidAcceptLanguage($language)
    {
        return in_array($language, self::$validAcceptLanguages);
    }
}
