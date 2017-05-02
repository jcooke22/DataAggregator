<?php

namespace DataAggregator\Statistic\Metric;

interface MetricInterface
{
    /**
     * @return string
     */
    public function type(): string;

    /**
     * @return array
     */
    public function dataPoints(): array;

    /**
     * @param int $hour
     * 
     * @return array
     */
    public function dataPointsForHour(int $hour): array;
}
