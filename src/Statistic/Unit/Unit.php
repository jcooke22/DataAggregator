<?php

namespace DataAggregator\Statistic\Unit;

use DataAggregator\Statistic\Metric\MetricInterface;
use InvalidArgumentException;

class Unit implements UnitInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var MetricInterface[]
     */
    private $metrics;

    /**
     * Unit constructor.
     * @param int $id
     * @param MetricInterface[] $metrics
     */
    public function __construct(int $id, MetricInterface ...$metrics)
    {
        $this->validateMetrics($metrics);
        $this->id = $id;
        $this->metrics = $metrics;
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @return MetricInterface[]
     */
    public function metrics(): array
    {
        return $this->metrics;
    }

    /**
     * @param MetricInterface[] $metrics
     */
    private function validateMetrics(array $metrics)
    {
        if (empty($metrics)) {
            throw new InvalidArgumentException('No Metric objects supplied');
        }
    }
}
