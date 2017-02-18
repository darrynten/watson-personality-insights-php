## watson-personality-insights-php

![Travis Build Status](https://travis-ci.org/darrynten/watson-personality-insights-php.svg?branch=master)
![StyleCI Status](https://styleci.io/repos/81687310/shield?branch=master)
[![codecov](https://codecov.io/gh/darrynten/watson-personality-insights-php/branch/master/graph/badge.svg)](https://codecov.io/gh/darrynten/watson-personality-insights-php)
![Packagist Version](https://img.shields.io/packagist/v/darrynten/watson-personality-insights-php.svg)
![MIT License](https://img.shields.io/github/license/darrynten/watson-personality-insights-php.svg)

A framework agnostic fully unit tested client for IBM Watson Personality
insights API.

For PHP 7.0+

### Install

```bash
composer require darrynten/watson-personality-insights-php
```

### Usage

```php
// Required config
$config = [
    'username' => $username,
    'password' => $password
];

// Get an instance
$instance = new PersonalityInsights($config);

// Add some text
$text = file_get_contents('sample.txt');
$instance->addText($text);

// Get the insights
$insights = $instance->getInsights();
```

Some things you can set

```php
// Set standard options
$instance->config->setConsumptionPreferences(true);
$instance->config->setRawScores(true);
$instance->config->setVersion('2017-01-01');
$instance->config->setContentTypeHeader('application/json');
$instance->config->setContentLanguageHeader('en');
$instance->config->setAcceptHeader('application/json');
$instance->config->setAcceptLanguageHeader('en');
$instance->config->setCsvHeaders(false);
// https://watson-api-explorer.mybluemix.net/apis/personality-insights-v3#!/personality45insights/profile

// Set caching of requests
$instance->config->setCaching(false);

// Opt in to Watson tracking (off by default)
$instance->config->setOptOut(false);

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

You can also add a `ContentItem` directly

```php
/**
 * All possible content item config options. Only the `text` one is
 * required.
 *
 * https://watson-api-explorer.mybluemix.net/apis/personality-insights-v3#!/personality45insights/profile
 *
 * Defaults
 *
 * id - An md5 of the text
 * created - 0
 * updated - 0
 * contenttype - 'text/plain'
 * language - en
 * parentid - null
 * reply - false
 * forward - false
 */
$contentConfig = [
    'text' => $text,          // The only required value
    'id' => $string,          // Is the md5 of the text if not set
    'created' => $timestamp,  // Is 0 if not set
    'updated' => $timestamp,  // Is 0 if not set
    'contenttype' => $string, // `text/plain` or `text/html`
    'language' => $string,    // `en` or similar
    'parentid' => $string,    // The ID of a parent item. Null if not set
    'reply' => $boolean,      // Indicates if it is a reply to another
    'forward' => $boolean,    // Indicates if it is a forwarded text
];

$contentItem = new ContentItem($contentConfig);
$contentItem->getContentItemJson();

$instance->addNewContentItem($contentItem);
```

## Notes

### Privacy

IBM have a mode that keeps a copy of your data on their side for the
apparent training of Watson. This is normally opt-out.

As this isn't explicitly made clear, we have decided to **disable by
default** so if you do with to help Watson learn then you can do
so by opting-in as outlined in the examples above.

By default this package will not allow any tracking of any kind.

### "Version"

This is the source of some confusion. This is a date in the format of
'YYYY-MM-DD' and Watson will use whichever version was around at that
time.

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

### Credentials

You can download your credentials in a `json` file, or get them from the
developer console.

[Details on IBM](https://www.ibm.com/watson/developercloud/doc/getting_started/gs-credentials.shtml)

### Unit tests

Test coverage is 100%, but you can also include a live API test to see
if everything is working on that end. You shouldn't have to though,
  but it can be useful.

To do live test export 

```bash
export DO_LIVE_API_TESTS=true
```

You must also include your real `credentials.json` in
the root of the project (it is already in the `gitignore`).

Which will then do the live test.

### Not yet supported

* Delete from ContentItems collection
* Modify within ContentItems collection
* Full error and exception handling
* Manipulation of the results
* Minimum text length configuration
* CSV

## Contributing and Testing

There is currently 100% test coverage in the project, please ensure that
when contributing you update the tests. For more info see CONTRIBUTING.md

## Acknowledgements

* [Dmitry Semenov](https://github.com/mxnr), as always.
* Add yourself here!
