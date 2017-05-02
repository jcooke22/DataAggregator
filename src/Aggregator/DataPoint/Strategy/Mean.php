<?php

namespace DataAggregator\Aggregator\DataPoint\Strategy;

use InvalidArgumentException;
use DataAggregator\Statistic\DataPoint\DataPoint;

class Mean implements StrategyInterface
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

        return array_sum(
                array_map(
                    function ($dataPoint) {
                        return $dataPoint->value();
                    },
                    $dataPoints
                )
            ) / count($dataPoints);

    }

    /**
     * @return string
     */
    public function type(): string
    {
        return 'mean';
    }
}
