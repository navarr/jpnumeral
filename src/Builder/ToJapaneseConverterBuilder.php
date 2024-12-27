<?php

declare(strict_types=1);

namespace JapaneseNumerals\Builder;

use JapaneseNumerals\Provider\FormalDivisionProvider;
use JapaneseNumerals\Provider\FormalMyriadProvider;
use JapaneseNumerals\Provider\FormalNumeralProvider;
use JapaneseNumerals\Provider\RegularDivisionProvider;
use JapaneseNumerals\Provider\RegularMyriadProvider;
use JapaneseNumerals\Provider\RegularNumeralProvider;
use JapaneseNumerals\ToJapaneseConverter;

class ToJapaneseConverterBuilder
{
    public function build(bool $useFormalNumerals = false, bool $useFormalDivisions = false, bool $useFormalMyriads = false): ToJapaneseConverter
    {
        $numeralProvider = $useFormalNumerals ? new FormalNumeralProvider() : new RegularNumeralProvider();
        $divisionProvider = $useFormalDivisions ? new FormalDivisionProvider() : new RegularDivisionProvider();
        $myriadProvider = $useFormalMyriads ? new FormalMyriadProvider() : new RegularMyriadProvider();

        return new ToJapaneseConverter($numeralProvider, $myriadProvider, $divisionProvider);
    }
}