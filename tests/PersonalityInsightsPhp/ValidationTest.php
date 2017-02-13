<?php

namespace DarrynTen\PersonalityInsightsPhp\Tests;

use PHPUnit_Framework_TestCase;
use DarrynTen\PersonalityInsightsPhp\Validation;

class ValidationTest extends PHPUnit_Framework_TestCase
{
    public function testValidVersionRegex()
    {
        $this->assertTrue(Validation::isValidVersionRegex('2000-01-01'));
    }

    public function testValidLanguage()
    {
        $this->assertTrue(Validation::isValidLanguageRegex('en'));
        $this->assertTrue(Validation::isValidLanguageRegex('en-ZA'));
    }

    public function testInvalidVersionRegex()
    {
        $this->assertFalse(Validation::isValidVersionRegex('BAR'));
    }

    public function testInvalidLanguage()
    {
        $this->assertFalse(Validation::isValidLanguageRegex('BAR'));
    }
}
