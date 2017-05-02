<?php

namespace DataAggregator\Providers;

use DataAggregator\Aggregator\DataPoint\Strategy\Count;
use DataAggregator\Aggregator\DataPoint\Strategy\Max;
use DataAggregator\Aggregator\DataPoint\Strategy\Mean;
use DataAggregator\Aggregator\DataPoint\Strategy\Median;
use DataAggregator\Aggregator\DataPoint\Strategy\Min;
use DataAggregator\Aggregator\UnitStatisticsAggregator;
use DataAggregator\Command\ProcessUnitAggregate;
use DataAggregator\Hydrator\DataPoint;
use DataAggregator\Hydrator\Metric;
use DataAggregator\Hydrator\Unit;
use DataAggregator\Repository\Aggregate;
use JsonCollectionParser\Parser;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigProvider implements ServiceProviderInterface
{
    const CONFIG_INPUT_JSON_PATH = 'config.input_json_path';
    const CONFIG_DATABASE_PARAMETERS = 'config.database_parameters';

    /**
     * @param Container $container
     */
    public function register(Container $container)
    {
        $container[static::CONFIG_INPUT_JSON_PATH] = function () {
            return realpath(__DIR__ . '/../../unit-statistic-data-dump.json');
        };

        $container[static::CONFIG_DATABASE_PARAMETERS] = function () {
            return [
                'host' => getenv('UNIT_AGGREGATE_MYSQL_HOST'),
                'driver' => 'pdo_mysql',
                'user' => getenv('UNIT_AGGREGATE_MYSQL_USER'),
                'password' => getenv('UNIT_AGGREGATE_MYSQL_PASSWORD'),
                'dbname' => getenv('UNIT_AGGREGATE_MYSQL_DATABASE_NAME'),
            ];
        };
    }
}