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
        return (bool)preg_match(self::$validVersionRegex, $version);
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
}
