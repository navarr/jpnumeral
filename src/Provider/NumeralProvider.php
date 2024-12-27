<?php

namespace JapaneseNumerals\Provider;

use JetBrains\PhpStorm\ExpectedValues;

interface NumeralProvider
{
    public function getNumeral(
        #[ExpectedValues([0, 1, 2, 3, 4, 5, 6, 7, 8, 9])]
        int $numeral
    ): string;
}