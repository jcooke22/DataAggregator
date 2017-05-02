<?php

namespace DataAggregator\Aggregator\DataPoint\Strategy;

use DataAggregator\Statistic\DataPoint\DataPoint;

interface StrategyInterface
{
    /**
     * @param DataPoint[] ...$dataPoints
     * @return mixed
     */
    public function aggregate(DataPoint ...$dataPoints);

    /**
     * @return string
     */
    public function type(): string;
}

