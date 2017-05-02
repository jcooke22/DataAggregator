<?php

namespace DataAggregator\Aggregator;

use DataAggregator\Aggregator\DataPoint\Strategy\StrategyInterface;
use DataAggregator\Entity\Aggregate;
use DataAggregator\Hydrator\HydratorInterface;
use DataAggregator\Repository\Aggregate as AggregateRepository;
use DataAggregator\Repository\AggregateInterface;
use DataAggregator\Statistic\Unit\Unit;
use stdClass;

class UnitStatisticsAggregator
{
    /**
     * @var HydratorInterface
     */
    private $unitHydrator;

    /**
     * @var AggregateInterface
     */
    private $aggregateRepository;
    
    /**
     * @var StrategyInterface[]
     */
    private $aggregateStrategies;

    /**
     * UnitStatisticsAggregator constructor.
     * @param HydratorInterface $unitHydrator
     * @param AggregateInterface $aggregateRepository
     * @param StrategyInterface[] $aggregateStrategies
     */
    public function __construct(
        HydratorInterface $unitHydrator,
        AggregateInterface $aggregateRepository,
        StrategyInterface ...$aggregateStrategies
    ) {
        $this->unitHydrator = $unitHydrator;
        $this->aggregateRepository = $aggregateRepository;
        $this->aggregateStrategies = $aggregateStrategies;
    }

    /**
     * @param stdClass $unit
     */
    public function __invoke(stdClass $unit)
    {
        $this->aggregate($this->unitHydrator->hydrate($unit));
    }

    /**
     * @param Unit $unit
     */
    private function aggregate(Unit $unit)
    {
        foreach ($unit->metrics() as $metric) {
            foreach (range(00, 23) as $hour) {
                if (empty($metric->dataPointsForHour($hour))) {
                    continue;
                }
                $aggregate = new Aggregate();
                $aggregate->setHour($hour);
                $aggregate->setMetric($metric->type());
                $aggregate->setUnitId($unit->id());
                foreach ($this->aggregateStrategies as $aggregateStrategy) {
                    $aggregate->setAggregateValue(
                        $aggregateStrategy->type(),
                        $aggregateStrategy->aggregate(...$metric->dataPointsForHour($hour))
                    );
                }
                $this->aggregateRepository->persist($aggregate);
            }
        }
    }
}
