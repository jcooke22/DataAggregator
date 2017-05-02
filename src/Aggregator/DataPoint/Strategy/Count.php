<?php

namespace DataAggregator\Aggregator\DataPoint\Strategy;

use DataAggregator\Statistic\DataPoint\DataPoint;

class Count implements StrategyInterface
{
    /**
     * @param DataPoint[] ...$dataPoints
     * @return int
     */
    public function aggregate(DataPoint ...$dataPoints)
    {
        return count($dataPoints);
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return 'total_data_points';
    }
}
