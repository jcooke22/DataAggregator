<?php

namespace DataAggregator\Statistic\DataPoint;

use DateTime;
use InvalidArgumentException;
use Throwable;

class DataPoint implements DataPointInterface
{
    /**
     * @var DateTime
     */
    private $timestamp;

    /**
     * @var mixed
     */
    private $value;

    /**
     * DataPoint constructor.
     * @param string $timestamp
     * @param $value
     */
    public function __construct(string $timestamp, $value)
    {
        try {
            $this->timestamp = new DateTime($timestamp);
        } catch (Throwable $e) {
            throw new InvalidArgumentException(sprintf("Invalid timestamp supplied: %s", $timestamp));
        }

        if (!is_numeric($value)) {
            throw new InvalidArgumentException("Invalid value supplied. Value must be numeric");
        }
        
        $this->value = $value;
    }

    /**
     * @return DateTime
     */
    public function timestamp(): DateTime
    {
        return $this->timestamp;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }
}
