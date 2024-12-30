<?php

namespace JapaneseNumerals\Test;

use JapaneseNumerals\Builder\ToJapaneseConverterBuilder;

class ToJapaneseConverterTest extends TestCase
{
    /**
     * @param non-empty-string $japanese
     * @param numeric-string $arabic
     * @dataProvider dataProvider
     */
    public function testConvertNonFormal(string $japanese, string $arabic): void
    {
        $builder = new ToJapaneseConverterBuilder();
        $converter = $builder->build();

        $this->assertEquals($japanese, $converter->convert($arabic));
    }
}
