<?php

declare(strict_types=1);

namespace JapaneseNumerals\Provider;

use InvalidArgumentException;
use JetBrains\PhpStorm\ExpectedValues;

class RegularDivisionProvider implements MyriadDivisionProvider
{
    public const DIVISIONS = [
        10 => '十',
        100 => '百',
        1000 => '千',
    ];

    public function getDivision(
        #[ExpectedValues([10, 100, 1000])]
        int $division
    ): string {
        if (!array_key_exists($division, self::DIVISIONS)) {
            throw new InvalidArgumentException("Unsupported division: $division");
        }
        return self::DIVISIONS[$division];
    }
}
