<?php

namespace App\Support;

class Vat
{
    public const DEFAULT_RATE = 0.21;

    public static function rateForCountry(?string $countryCode): float
    {
        return strtoupper((string) $countryCode) === 'EE' ? 0.22 : self::DEFAULT_RATE;
    }

    public static function multiplierForCountry(?string $countryCode): float
    {
        return 1 + self::rateForCountry($countryCode);
    }

    public static function percentForCountry(?string $countryCode): int
    {
        return (int) round(self::rateForCountry($countryCode) * 100);
    }
}
