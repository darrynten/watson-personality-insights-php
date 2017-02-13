## watson-personality-insights-php

A framework agnostic fully unit tested client for IBM Watson Personality
insights API.

### Install

```bash
composer require darrynten/watson-personality-insights
```

### Usage

```php
// Required config
$config = [
    'username' => $username,
    'password' => $password
];

// Get an instance
$personality = new PersonalityInsights($config);

// Set some text
$text = file_get_contents('sample.txt');
$personality->setText($text);

// Get the insights
$insights = $personality->getInsights();

// Receive raw scores back
$personality->setRawScores(true);

// Receive consumption preferences
$personality->setConsumptionPreferences(true);

// Change the version
$personality->version = '2012-01-01';

// Disable caching
$personality->setCaching(false);

// All config options
$config = [
    'username' => $username,
    'password' => $password,
    'version' => $version,
    'raw_scores' => $boolean,
    'consumption_preferences' => $boolean,
    'cache' => $boolean,
];

```

## Notes

### "Version"

This is the source of some confusion. This is a date in the format of
'YYYY-MM-DD' and Watson will use whichever version was around at that time.

Full quote

> The requested version of the response format as a date in the form
YYYY-MM-DD; for example, specify 2016-10-20 for October 20, 2016. The
date that you specify does not need to match a version of the service
exactly; the service replies with the response format whose version is
no later than the date you provide. If you specify a date that is earlier
than the initial release of version 3, the service returns the response
format for that first version. If you specify a date that is in the future
or otherwise later than the most recent version, the service returns the
response format for the latest version.

### Not yet supported

* CSV support

## Acknowledgements

* Add yourself here!
