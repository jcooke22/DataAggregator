<?php

namespace DataAggregator\Statistic\Metric;

use DataAggregator\Statistic\DataPoint\DataPoint;
use DataAggregator\Statistic\DataPoint\DataPointInterface;
use InvalidArgumentException;

class Metric implements MetricInterface
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var DataPointInterface[]
     */
    private $dataPoints;

    /**
     * Metric constructor.
     * @param string $type
     * @param DataPointInterface[] $dataPoints
     */
    public function __construct(string $type, DataPointInterface ...$dataPoints)
    {
        $this->validateDataPoints($dataPoints);
        $this->type = $type;
        $this->dataPoints = $dataPoints;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return DataPointInterface[]
     */
    public function dataPoints(): array
    {
        return $this->dataPoints;
    }

    /**
     * @param int $hour
     *
     * @return array
     */
    public function dataPointsForHour(int $hour): array
    {
        return array_filter(
            $this->dataPoints,
            function (DataPointInterface $dataPoint) use ($hour) {
                return $dataPoint->timestamp()->format('H') == $hour;
            }
        );
    }


    /**
     * @param DataPointInterface[] $dataPoints
     */
    private function validateDataPoints(array $dataPoints)
    {
        if (empty($dataPoints)) {
            throw new InvalidArgumentException('No DataPoint objects supplied');
        }
    }
}
