<?php

namespace DataAggregator\Aggregator\DataPoint\Strategy;

use InvalidArgumentException;
use DataAggregator\Statistic\DataPoint\DataPoint;

class Median implements StrategyInterface
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

        return $this->median(
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
        return 'median';
    }

    private function median(array $array)
    {
        if (empty($array)) {
            throw new InvalidArgumentException("No data points passed");
        }

        $count = count($array);
        asort($array);
        $mid = floor(($count - 1) / 2);
        $keys = array_slice(array_keys($array), $mid, (1 === $count % 2 ? 1 : 2));
        $sum = 0;
        foreach ($keys as $key) {
            $sum += $array[$key];
        }
        return $sum / count($keys);
    }
}
