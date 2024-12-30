<?php

declare(strict_types=1);

namespace JapaneseNumerals\Provider;

use JetBrains\PhpStorm\ExpectedValues;

class FormalNumeralProvider extends RegularNumeralProvider
{
    public function getNumeral(
        #[ExpectedValues([0, 1, 2, 3, 4, 5, 6, 7, 8, 9])]
        int $numeral
    ): string {
        return match ($numeral) {
            0 => '零',
            1 => '壱',
            2 => '弐',
            3 => '参',
            default => parent::getNumeral($numeral),
        };
    }
}
