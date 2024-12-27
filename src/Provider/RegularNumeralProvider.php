<?php

declare(strict_types=1);

namespace JapaneseNumerals\Provider;

use InvalidArgumentException;
use JetBrains\PhpStorm\ExpectedValues;

class RegularNumeralProvider implements NumeralProvider
{
    private const NUMERALS = [
        0 => '〇',
        1 => '一',
        2 => '二',
        3 => '三',
        4 => '四',
        5 => '五',
        6 => '六',
        7 => '七',
        8 => '八',
        9 => '九',
    ];

    public function getNumeral(
        #[ExpectedValues([0, 1, 2, 3, 4, 5, 6, 7, 8, 9])]
        int $numeral
    ): string {
        if (!array_key_exists($numeral, self::NUMERALS)) {
            throw new InvalidArgumentException(
                'Invalid numeral.  You must provide a numeral between 0 and 9 inclusive.'
            );
        }
        return self::NUMERALS[$numeral];
    }
}