<?php

namespace JapaneseNumerals\Provider;

use InvalidArgumentException;

interface MyriadProvider
{
    /**
     * @throws InvalidArgumentException If an unsupported power is given
     */
    public function getByPower(int $power): string;

    /**
     * @throws InvalidArgumentException If an unsupported index is given
     */
    public function getByIndex(int $index): string;
}
