<?php

namespace DataAggregator\Providers;

use DataAggregator\Aggregator\DataPoint\Strategy\Count;
use DataAggregator\Aggregator\DataPoint\Strategy\Max;
use DataAggregator\Aggregator\DataPoint\Strategy\Mean;
use DataAggregator\Aggregator\DataPoint\Strategy\Median;
use DataAggregator\Aggregator\DataPoint\Strategy\Min;
use DataAggregator\Aggregator\UnitStatisticsAggregator;
use DataAggregator\Command\ProcessUnitAggregate;
use DataAggregator\Command\QueryUnitAggregate;
use DataAggregator\Hydrator\DataPoint;
use DataAggregator\Hydrator\Metric;
use DataAggregator\Hydrator\Unit;
use DataAggregator\Repository\Aggregate;
use JsonCollectionParser\Parser;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class CommandProvider implements ServiceProviderInterface
{
    const COMMAND_PROCESS_UNIT_AGGREGATE = 'command.process_unit_aggregate';
    const COMMAND_QUERY_UNIT_AGGREGATE = 'command.query_unit_aggregate';

    /**
     * @param Container $container
     */
    public function register(Container $container)
    {
        $container[static::COMMAND_PROCESS_UNIT_AGGREGATE] = function () use ($container) {
            return new ProcessUnitAggregate(
                null,
                $container['config.input_json_path'],
                new Parser(),
                new UnitStatisticsAggregator(
                    new Unit(new Metric(new DataPoint())),
                    $container['repository.aggregate'],
                    new Min(),
                    new Max(),
                    new Count(),
                    new Mean(),
                    new Median()
                )
            );
        };
        $container[static::COMMAND_QUERY_UNIT_AGGREGATE] = function () use ($container) {
            return new QueryUnitAggregate(null, $container[RepositoryProvider::REPOSITORY_AGGREGATE]);
        };
    }
}