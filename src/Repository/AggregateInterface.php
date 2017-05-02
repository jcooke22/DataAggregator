<?php

namespace DataAggregator\Repository;

use DataAggregator\Entity\Aggregate as AggregateEntity;

interface AggregateInterface
{
    /**
     * @param int $unitId
     * @param int $hour
     * @param string $metric
     * 
     * @return AggregateEntity
     */
    public function findByUnitIdHourMetric(int $unitId, int $hour, string $metric) : AggregateEntity;

    /**
     * @param AggregateEntity $aggregate
     * 
     * @return mixed
     */
    public function persist(AggregateEntity $aggregate);
}
