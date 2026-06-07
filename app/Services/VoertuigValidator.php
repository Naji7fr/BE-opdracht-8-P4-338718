<?php

namespace App\Services;

class VoertuigValidator
{
    public static function isPositiveInteger(mixed $value): bool
    {
        if (! is_numeric($value)) {
            return false;
        }

        $intValue = (int) $value;

        return $intValue > 0 && (string) $intValue === (string) $value;
    }

    public static function formatSterren(int $aantal): string
    {
        if ($aantal < 0) {
            $aantal = 0;
        }

        return str_repeat('*', $aantal);
    }

    public static function formatDatum(mixed $datum): string
    {
        if ($datum instanceof \DateTimeInterface) {
            return $datum->format('d-m-Y');
        }

        $timestamp = strtotime((string) $datum);

        if ($timestamp === false) {
            return (string) $datum;
        }

        return date('d-m-Y', $timestamp);
    }
}
