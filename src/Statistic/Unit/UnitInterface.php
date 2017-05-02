<?php

namespace DataAggregator\Statistic\Unit;

interface UnitInterface
{
    /**
     * @return int
     */
    public function id(): int;

    /**
     * @return array
     */
    public function metrics(): array;
}
