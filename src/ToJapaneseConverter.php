<?php

declare(strict_types=1);

namespace JapaneseNumerals;

use InvalidArgumentException;
use JapaneseNumerals\Provider\MyriadDivisionProvider;
use JapaneseNumerals\Provider\MyriadProvider;
use JapaneseNumerals\Provider\NumeralProvider;
use JapaneseNumerals\Provider\RegularDivisionProvider;
use JapaneseNumerals\Provider\RegularMyriadProvider;
use JapaneseNumerals\Provider\RegularNumeralProvider;
use Stringable;

class ToJapaneseConverter
{
    public function __construct(
        private readonly NumeralProvider $numeralProvider = new RegularNumeralProvider(),
        private readonly MyriadProvider $myriadProvider = new RegularMyriadProvider(),
        private readonly MyriadDivisionProvider $divisionProvider = new RegularDivisionProvider(),
    ) {
    }

    private function convertLeftOfDecimal(string $number): string
    {
        $dataArray = [];

        $placeHolderAmount = (int)((ceil(strlen($number) / 4) * 4) - strlen($number));
        $stringNumber = str_repeat('0', $placeHolderAmount) . $number;

        $myriadStartIndex = 4;
        while ($myriadStartIndex <= strlen($stringNumber)) {
            $dataArray[] = substr($stringNumber, -$myriadStartIndex, 4);
            $myriadStartIndex += 4;
        }

        $myriadStrings = [];
        foreach ($dataArray as $myriadIndex => $value) {
            if (intval($value) == 0) {
                continue;
            }

            $myriadStringPieces = [];

            // Thousands Place
            $thousandsInt = (int)substr($value, -4, 1);
            if ($thousandsInt > 1) {
                $myriadStringPieces[] = $this->numeralProvider->getNumeral($thousandsInt);
            }
            if ($thousandsInt > 0) {
                $myriadStringPieces[] = $this->divisionProvider->getDivision(1000);
            }

            // Hundreds Place
            $hundredsInt = (int)substr($value, -3, 1);
            if ($hundredsInt > 1) {
                $myriadStringPieces[] = $this->numeralProvider->getNumeral($hundredsInt);
            }
            if ($hundredsInt > 0) {
                $myriadStringPieces[] = $this->divisionProvider->getDivision(100);
            }

            // Tens Place
            $tensInt = (int)substr($value, -2, 1);
            if ($tensInt > 1) {
                $myriadStringPieces[] = $this->numeralProvider->getNumeral($tensInt);
            }
            if ($tensInt > 0) {
                $myriadStringPieces[] = $this->divisionProvider->getDivision(10);
            }

            // Ones Place
            $onesInt = (int)substr($value, -1, 1);
            if ($onesInt > 0) {
                $myriadStringPieces[] = $this->numeralProvider->getNumeral($onesInt);
            }

            $myriadStringPieces[] = $this->myriadProvider->getByIndex($myriadIndex);
            $myriadStrings[] = $myriadStringPieces;
        }

        return empty($myriadStrings)
            ? $this->numeralProvider->getNumeral(0)
            : implode('', array_merge(...$myriadStrings));
    }

    private function convertRightOfDecimal(string $number): string
    {
        $decimalStringPieces = [];
        for ($i = 0; $i < strlen($number); $i++) {
            $decimalStringPieces[] = $this->numeralProvider->getNumeral((int)$number[$i]);
        }

        return implode('', $decimalStringPieces);
    }

    public function convert(int|float|string|Stringable $number): string
    {
        if (!is_numeric($number)) {
            throw new InvalidArgumentException('You must provide a number.');
        }

        $number = (string)$number;

        if (!str_contains($number, '.')) {
            return $this->convertLeftOfDecimal($number);
        }

        [$left, $right] = explode('.', $number);
        return $this->convertLeftOfDecimal($left) . '・' . $this->convertRightOfDecimal($right);
    }
}