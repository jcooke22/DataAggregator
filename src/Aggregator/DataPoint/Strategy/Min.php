<?php

namespace DataAggregator\Aggregator\DataPoint\Strategy;

use InvalidArgumentException;
use DataAggregator\Statistic\DataPoint\DataPoint;

class Min implements StrategyInterface
{
    /**
     * @param DataPoint[] ...$dataPoints
     * @return int
     */
    public function aggregate(DataPoint ...$dataPoints)
    {
        if (empty($dataPoints)) {
            throw new InvalidArgumentException("No data points passed");
        }

        return min(
            array_map(
                function ($dataPoint) {
                    return $dataPoint->value();
                },
                $dataPoints
            )
        );
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return 'min';
    }
}
