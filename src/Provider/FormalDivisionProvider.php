<?php

declare(strict_types=1);

namespace JapaneseNumerals\Provider;

use JetBrains\PhpStorm\ExpectedValues;

class FormalDivisionProvider extends RegularDivisionProvider
{
    public function getDivision(
        #[ExpectedValues([10, 100, 1000])]
        int $division
    ): string {
        return match ($division) {
            10 => '拾',
            default => parent::getDivision($division),
        };
    }
}
