<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class VoertuigValidatorTest extends TestCase
{
    public function testIsPositiveIntegerReturnsTrueForValidValues(): void
    {
        $this->assertTrue(VoertuigValidator::isPositiveInteger(1));
        $this->assertTrue(VoertuigValidator::isPositiveInteger('42'));
    }

    public function testIsPositiveIntegerReturnsFalseForInvalidValues(): void
    {
        $this->assertFalse(VoertuigValidator::isPositiveInteger(0));
        $this->assertFalse(VoertuigValidator::isPositiveInteger(-5));
        $this->assertFalse(VoertuigValidator::isPositiveInteger('abc'));
        $this->assertFalse(VoertuigValidator::isPositiveInteger('1.5'));
    }

    public function testFormatSterrenReturnsCorrectStars(): void
    {
        $this->assertSame('*****', VoertuigValidator::formatSterren(5));
        $this->assertSame('***', VoertuigValidator::formatSterren(3));
        $this->assertSame('', VoertuigValidator::formatSterren(0));
    }

    public function testFormatDatumReturnsDutchFormat(): void
    {
        $this->assertSame('14-06-2010', VoertuigValidator::formatDatum('2010-06-14'));
    }
}
