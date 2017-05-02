<?php

namespace DataAggregator\Entity;

use InvalidArgumentException;

/**
 * @Entity(repositoryClass="DataAggregator\Repository\Aggregate")
 * @Table(name="aggregate")
 */
class Aggregate
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @Column(type="integer")
     */
    private $unit_id;

    /**
     * @Column(type="integer")
     */
    private $hour;

    /**
     * @Column(type="string")
     */
    private $metric;

    /**
     * @Column(type="integer")
     * @var mixed
     */
    private $min;

    /**
     * @Column(type="integer")
     * @var mixed
     */
    private $max;

    /**
     * @Column(type="integer")
     * @var mixed
     */
    private $mean;

    /**
     * @Column(type="integer")
     * @var mixed
     */
    private $median;

    /**
     * @Column(type="integer")
     * @var int
     */
    private $total_data_points;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return mixed
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @return mixed
     */
    public function getMean()
    {
        return $this->mean;
    }

    /**
     * @return mixed
     */
    public function getMedian()
    {
        return $this->median;
    }

    /**
     * @return int
     */
    public function getTotalDataPoints()
    {
        return $this->total_data_points;
    }

    /**
     * @return mixed
     */
    public function getUnitId()
    {
        return $this->unit_id;
    }

    /**
     * @param mixed $unit_id
     */
    public function setUnitId($unit_id)
    {
        $this->unit_id = $unit_id;
    }

    /**
     * @return mixed
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @param mixed $hour
     */
    public function setHour($hour)
    {
        $this->hour = $hour;
    }

    /**
     * @return mixed
     */
    public function getMetric()
    {
        return $this->metric;
    }

    /**
     * @param mixed $metric
     */
    public function setMetric($metric)
    {
        $this->metric = $metric;
    }

    /**
     * @param string $name
     * @param $value
     */
    public function setAggregateValue(string $name, $value)
    {
        if (!in_array($name, ['min', 'max', 'mean', 'median', 'total_data_points'])) {
            throw new InvalidArgumentException(sprintf("Invalid aggregate name: %s", $name));
        }

        $this->$name = $value;
    }
}
