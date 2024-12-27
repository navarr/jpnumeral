<?php

declare(strict_types=1);

namespace JapaneseNumerals\Provider;

use JetBrains\PhpStorm\ExpectedValues;

class FormalMyriadProvider extends RegularMyriadProvider
{
    private const FORMAL_MYRIAD_1 = '萬';

    public function getByPower(
        #[ExpectedValues([0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68])]
        int $power
    ): string {
        return match ($power) {
            4 => self::FORMAL_MYRIAD_1,
            default => parent::getByPower($power),
        };
    }

    public function getByIndex(
        #[ExpectedValues([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17])]
        int $index
    ): string {
        return match ($index) {
            1 => self::FORMAL_MYRIAD_1,
            default => parent::getByIndex($index),
        };
    }
}