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

/**
 * Convenient builder for creating ToJapaneseConverter instances
 *
 * This file simplifies the construction of ToJapaneseConverter classes for the typical use-case.
 *
 * @SuppressWarnings("PHPMD.BooleanArgumentFlag")
 */
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