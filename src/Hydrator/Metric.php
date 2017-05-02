<?php

namespace DataAggregator\Hydrator;

use DataAggregator\Exception\HydratorException;
use InvalidArgumentException;
use DataAggregator\Statistic\Metric\Metric as MetricValueObject;

class Metric implements HydratorInterface
{
    const METRIC_TYPES = ['download', 'upload', 'latency', 'packet_loss'];

    /**
     * @var DataPoint
     */
    private $dataPointHydrator;

    /**
     * Metric constructor.
     * @param HydratorInterface $dataPointHydrator
     */
    public function __construct(HydratorInterface $dataPointHydrator)
    {
        $this->dataPointHydrator = $dataPointHydrator;
    }

    /**
     * @param mixed $data
     *
     * @throws HydratorException
     * 
     * @return mixed
     */
    public function hydrate($data)
    {
        $this->validateDto($data);

        foreach (static::METRIC_TYPES as $metricType) {
            $dataPoints = [];
            foreach ($data->$metricType as $dataPointDto) {
                $dataPoints[] = $this->dataPointHydrator->hydrate($dataPointDto);
            }
            yield new MetricValueObject($metricType, ...$dataPoints);
        }
    }

    /**
     * @param $data
     */
    private function validateDto($data)
    {
        if (!is_object($data)) {
            throw new InvalidArgumentException("DTO cannot be hydrated as it is not an object");
        }
        foreach (static::METRIC_TYPES as $metricType) {
            if (!isset($data->$metricType)) {
                throw new InvalidArgumentException(
                    sprintf("DTO cannot be hydrated as it is missing %s", $metricType)
                );
            }
            if (!is_array($data->$metricType)) {
                throw new InvalidArgumentException(
                    sprintf("DTO cannot be hydrated as it is missing array %s", $metricType)
                );
            }
        }
    }
}
