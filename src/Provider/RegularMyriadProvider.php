<?php

declare(strict_types=1);

namespace JapaneseNumerals\Provider;

use InvalidArgumentException;
use JetBrains\PhpStorm\ExpectedValues;

class RegularMyriadProvider implements MyriadProvider
{
    private const BY_POWER = [
        0 => '',
        4 => '万',
        8 => '億',
        12 => '兆',
        16 => '京',
        20 => '垓',
        24 => '秭',
        28 => '穣',
        32 => '溝',
        36 => '澗',
        40 => '正',
        44 => '載',
        48 => '極',
        52 => '恒河沙',
        56 => '阿僧祇',
        60 => '那由他',
        64 => '不可思議',
        68 => '無量大数',
    ];

    public function getByPower(
        #[ExpectedValues([0, 4, 8, 12, 16, 20, 24, 28, 32, 36, 40, 44, 48, 52, 56, 60, 64, 68])]
        int $power
    ): string {
        if (!array_key_exists($power, self::BY_POWER)) {
            throw new InvalidArgumentException(
                'Invalid power.  You must provide a power of 10 that is divisible by 4 between 0 and 68 inclusive.'
            );
        }
        return self::BY_POWER[$power];
    }

    public function getByIndex(
        #[ExpectedValues([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17])]
        int $index
    ): string {
        $index *= 4;
        if (!array_key_exists($index, self::BY_POWER)) {
            throw new InvalidArgumentException('Invalid index.  You must provide an index between 0 and 17 inclusive.');
        }
        return self::BY_POWER[$index];
    }
}
