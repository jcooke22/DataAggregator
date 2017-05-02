<?php

namespace DataAggregator\Repository;

use DataAggregator\Entity\Aggregate as AggregateEntity;
use DataAggregator\Exception\RepositoryException;
use Doctrine\ORM\EntityRepository;
use Throwable;

class Aggregate extends EntityRepository implements AggregateInterface
{
    /**
     * @param int $unitId
     * @param int $hour
     * @param string $metric
     *
     * @return AggregateEntity
     */
    public function findByUnitIdHourMetric(int $unitId, int $hour, string $metric): AggregateEntity
    {
        $query = 'SELECT a
                  FROM DataAggregator\Entity\Aggregate a
                  WHERE a.unit_id = :unit_id
                  AND a.hour = :hour
                  AND a.metric = :metric';
        $parameters = ['unit_id' => $unitId, 'hour' => $hour, 'metric' => $metric];

        try {
            $result = $this
                ->_em
                ->createQuery($query)
                ->setParameters($parameters)
                ->getOneOrNullResult();
        } catch (Throwable $e) {
            throw new RepositoryException($e->getMessage());
        }

        if (!$result instanceof AggregateEntity) {
            throw new RepositoryException(
                sprintf(
                    "Failed to find a Aggregate for unitId %d, hour %d, metric %s",
                    $unitId,
                    $hour,
                    $metric
                )
            );
        }

        return $result;
    }

    /**
     * @param AggregateEntity $aggregate
     * 
     * @return void
     */
    public function persist(AggregateEntity $aggregate)
    {
        $this->_em->persist($aggregate);
        $this->_em->flush();
    }
}
