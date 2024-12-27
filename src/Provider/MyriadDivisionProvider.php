<?php

namespace JapaneseNumerals\Provider;

use JetBrains\PhpStorm\ExpectedValues;

interface MyriadDivisionProvider
{
    public function getDivision(
        #[ExpectedValues([10,100,1000])]
        int $division
    ): string;
}