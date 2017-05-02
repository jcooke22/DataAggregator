<?php

namespace DataAggregator\Hydrator;

use InvalidArgumentException;
use DataAggregator\Statistic\Unit\Unit as UnitValueObject;

class Unit implements HydratorInterface
{
    /**
     * @var Metric
     */
    private $metricHydrator;

    /**
     * Unit constructor.
     * @param HydratorInterface $metricHydrator
     */
    public function __construct(HydratorInterface $metricHydrator)
    {
        $this->metricHydrator = $metricHydrator;
    }

    /**
     * @param mixed $data
     *
     * @return mixed
     */
    public function hydrate($data)
    {
        $this->validateDto($data);

        $metrics = [];
        foreach ($this->metricHydrator->hydrate($data->metrics) as $metric) {
            $metrics[] = $metric;
        }

        return new UnitValueObject($data->unit_id, ...$metrics);
    }

    /**
     * @param $data
     *
     * @throws InvalidArgumentException
     */
    private function validateDto($data)
    {
        if (!is_object($data)) {
            throw new InvalidArgumentException("DTO cannot be hydrated as it is not an object");
        }
        if (!isset($data->unit_id)) {
            throw new InvalidArgumentException("DTO cannot be hydrated as it is missing the unit_id");
        }

        if (!isset($data->metrics)) {
            throw new InvalidArgumentException("DTO cannot be hydrated as it is missing the metrics");
        }
    }

}
