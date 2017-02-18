<?php
/**
 * Watson Personality Insights API Exception
 *
 * @category Exception
 * @package  PersonalityInsightsPhp
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/watson-personality-insights-php/LICENSE>
 * @link     https://github.com/darrynten/watson-personality-insights-php
 */

namespace DarrynTen\PersonalityInsightsPhp;

use \Exception;

/**
 * Custom exception for PersonalityInsights Client
 *
 * @package PersonalityInsightsPhp
 */
class CustomException extends Exception
{

    /**
     * @inheritdoc
     *
     * @param string    $message  The message to throw
     * @param integer   $code     The error code to throw
     * @param Exception $previous The previous exception
     */
    public function __construct(string $message = '', int $code = 0, Exception $previous = null)
    {
        // Construct message from JSON if required.
        if (preg_match('/^[\[\{]\"/', $message)) {
            $messageObject = json_decode($message);
            $message = sprintf(
                '%s: %s - %s',
                $messageObject->status,
                $messageObject->title,
                $messageObject->detail
            );
            if (!empty($messageObject->errors)) {
                $message .= ' ' . serialize($messageObject->errors);
            }
        }

        parent::__construct($message, $code, $previous);
    }
}
