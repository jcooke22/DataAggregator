<?php

namespace DataAggregator\Hydrator;

use InvalidArgumentException;
use DataAggregator\Exception\HydratorException;
use DataAggregator\Statistic\DataPoint\DataPoint as DataPointValueObject;
use DataAggregator\Statistic\DataPoint\DataPointInterface;

class DataPoint implements HydratorInterface
{
    /**
     * @param mixed $data
     *
     * @throws HydratorException
     *
     * @return DataPointInterface
     */
    public function hydrate($data): DataPointInterface
    {
        $this->validateDto($data);
        try {
            return new DataPointValueObject($data->timestamp, $data->value);
        } catch (InvalidArgumentException $e) {
            throw new HydratorException($e->getMessage());
        }
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
        if (!isset($data->timestamp)) {
            throw new InvalidArgumentException("DTO cannot be hydrated as it is missing the timestamp");
        }
        if (!isset($data->value)) {
            throw new InvalidArgumentException("DTO cannot be hydrated as it is missing the value");
        }
    }
}
