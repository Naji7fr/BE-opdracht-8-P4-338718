<?php

declare(strict_types=1);

class VoertuigValidator
{
    public static function isPositiveInteger(mixed $value): bool
    {
        if (!is_numeric($value)) {
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

    public static function formatDatum(string $datum): string
    {
        $timestamp = strtotime($datum);

        if ($timestamp === false) {
            return $datum;
        }

        return date('d-m-Y', $timestamp);
    }
}
