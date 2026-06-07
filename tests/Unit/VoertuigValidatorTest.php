<?php

namespace Tests\Unit;

use App\Services\VoertuigValidator;
use PHPUnit\Framework\TestCase;

class VoertuigValidatorTest extends TestCase
{
    public function test_is_positive_integer_returns_true_for_valid_values(): void
    {
        $this->assertTrue(VoertuigValidator::isPositiveInteger(1));
        $this->assertTrue(VoertuigValidator::isPositiveInteger('42'));
    }

    public function test_is_positive_integer_returns_false_for_invalid_values(): void
    {
        $this->assertFalse(VoertuigValidator::isPositiveInteger(0));
        $this->assertFalse(VoertuigValidator::isPositiveInteger(-5));
        $this->assertFalse(VoertuigValidator::isPositiveInteger('abc'));
    }

    public function test_format_sterren_returns_correct_stars(): void
    {
        $this->assertSame('*****', VoertuigValidator::formatSterren(5));
        $this->assertSame('***', VoertuigValidator::formatSterren(3));
    }

    public function test_format_datum_returns_dutch_format(): void
    {
        $this->assertSame('14-06-2010', VoertuigValidator::formatDatum('2010-06-14'));
    }
}
