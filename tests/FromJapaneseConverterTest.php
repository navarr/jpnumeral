<?php

namespace JapaneseNumerals\Test;

use JapaneseNumerals\FromJapaneseConverter;

class FromJapaneseConverterTest extends TestCase
{
    /**
     * @param non-empty-string $japanese
     * @param numeric-string $arabic
     * @dataProvider dataProvider
     */
    public function testConvert(string $japanese, string $arabic): void
    {
        $converter = new FromJapaneseConverter();

        $this->assertEquals($arabic, $converter->convert($japanese));
    }
}
