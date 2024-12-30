<?php

namespace JapaneseNumerals\Test;

use JapaneseNumerals\Builder\ToJapaneseConverterBuilder;
use JapaneseNumerals\ToJapaneseConverter;

class ToJapaneseConverterTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

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
