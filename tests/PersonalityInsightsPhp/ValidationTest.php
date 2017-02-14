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

    public function testValidTypes()
    {
        $this->assertTrue(Validation::isValidContentType('application/json'));
        $this->assertTrue(Validation::isValidContentType('text/html'));
        $this->assertTrue(Validation::isValidContentType('text/plain'));

        $this->assertTrue(Validation::isValidContentLanguage('en'));
        $this->assertTrue(Validation::isValidContentLanguage('ar'));
        $this->assertTrue(Validation::isValidContentLanguage('ja'));
        $this->assertTrue(Validation::isValidContentLanguage('es'));

        $this->assertTrue(Validation::isValidAcceptType('application/json'));
        $this->assertTrue(Validation::isValidAcceptType('text/csv'));

        $this->assertTrue(Validation::isValidAcceptLanguage('en'));
        $this->assertTrue(Validation::isValidAcceptLanguage('ar'));
        $this->assertTrue(Validation::isValidAcceptLanguage('de'));
        $this->assertTrue(Validation::isValidAcceptLanguage('es'));
        $this->assertTrue(Validation::isValidAcceptLanguage('fr'));
        $this->assertTrue(Validation::isValidAcceptLanguage('it'));
        $this->assertTrue(Validation::isValidAcceptLanguage('ja'));
        $this->assertTrue(Validation::isValidAcceptLanguage('ko'));
        $this->assertTrue(Validation::isValidAcceptLanguage('pt-br'));
        $this->assertTrue(Validation::isValidAcceptLanguage('zh-cn'));
        $this->assertTrue(Validation::isValidAcceptLanguage('zh-tw'));
    }

    public function testInvalidTypes()
    {
        $this->assertFalse(Validation::isValidContentType('text'));
        $this->assertFalse(Validation::isValidContentLanguage('sw'));
        $this->assertFalse(Validation::isValidAcceptType('json'));
        $this->assertFalse(Validation::isValidAcceptLanguage('sw'));
    }
}
