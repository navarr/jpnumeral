<?php

declare(strict_types=1);

namespace JapaneseNumerals;

use InvalidArgumentException;
use Stringable;

class FromJapaneseConverter
{
    private const NUMERAL_MAPPING = [
        '〇' => 0,
        '零' => 0,
        '一' => 1,
        '壱' => 1,
        '二' => 2,
        '弐' => 2,
        '三' => 3,
        '参' => 3,
        '四' => 4,
        '五' => 5,
        '六' => 6,
        '七' => 7,
        '八' => 8,
        '九' => 9,
    ];

    private const MYRIAD_DIVISIONS_MAPPING = [
        '十' => 10,
        '拾' => 10,
        '百' => 100,
        '千' => 1000,
    ];

    // What power of ten each myriad is
    private const MYRIAD_MAPPING = [
        '万' => '4',
        '萬' => '4',
        '億' => '8',
        '兆' => '12',
        '京' => '16',
        '垓' => '20',
        '秭' => '24',
        '穣' => '28',
        '溝' => '32',
        '澗' => '36',
        '正' => '40',
        '載' => '44',
        '極' => '48',
        '恒河沙' => '52',
        '阿僧祇' => '56',
        '那由他' => '60',
        '不可思議' => '64',
        '無量大数' => '68',
    ];

    private function convertLeftOfDecimal(string $number): string
    {
        $result = '0';
        $remainingNumber = $number;

        $mapping = array_reduce(array_keys(self::MYRIAD_MAPPING), function ($carry, $item) {
            $carry[$item] = bcpow('10', self::MYRIAD_MAPPING[$item]);
            return $carry;
        }, []);
        arsort($mapping, SORT_NATURAL);

        foreach ($mapping as $key => $value) {
            $check = explode($key, $remainingNumber);
            if (count($check) > 2) {
                throw new InvalidArgumentException('Invalid number format.');
            }
            if (count($check) === 2) {
                if ($check[0] === '') {
                    $left = '1';
                    // Technically invalid... but it's fine
                } else {
                    $left = $this->convertDivision($check[0]);
                }
                $result = bcadd($result, bcmul((string)$left, (string)$value));
                $remainingNumber = $check[1];
            }
        }
        if ($remainingNumber !== '') {
            $result = bcadd($result, (string)$this->convertDivision($remainingNumber));
        }
        return $result;
    }

    private function convertDivision(string $number): int
    {
        $result = 0;
        $remainingNumber = $number;

        $mapping = self::MYRIAD_DIVISIONS_MAPPING;
        arsort($mapping);

        foreach ($mapping as $key => $value) {
            $check = explode($key, $remainingNumber);
            if (count($check) > 2) {
                throw new InvalidArgumentException('Invalid number format.');
            }
            if (count($check) === 2) {
                if ($check[0] === '') {
                    $left = 1;
                } else {
                    $left = $this->convertNumeral($check[0]);
                }
                $result += $left * $value;
                $remainingNumber = $check[1];
            }
        }
        if ($remainingNumber !== '') {
            $result += $this->convertNumeral($remainingNumber);
        }
        return $result;
    }

    private function convertNumeral(string $japaneseNumeral): int
    {
        if (!isset(self::NUMERAL_MAPPING[$japaneseNumeral])) {
            throw new InvalidArgumentException('Invalid numeral: ' . $japaneseNumeral);
        }
        return self::NUMERAL_MAPPING[$japaneseNumeral];
    }

    private function convertRightOfDecimal(string $number): string
    {
        $numberPieces = mb_str_split($number);
        $arabicPieces = array_map(fn($piece) => $this->convertNumeral($piece), $numberPieces);

        return implode('', $arabicPieces);
    }

    public function convert(int|string|Stringable $number): string
    {
        // String replace various types of decimals to "."
        $number = str_replace(['．', '。', '・'], '.', (string)$number);
        $numberParts = explode('.', $number);
        return count($numberParts) === 1
            ? $this->convertLeftOfDecimal($numberParts[0])
            : $this->convertLeftOfDecimal($numberParts[0]) . '.' . $this->convertRightOfDecimal($numberParts[1]);
    }
}