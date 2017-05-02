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
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use JsonCollectionParser\Parser;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class RepositoryProvider implements ServiceProviderInterface
{
    const REPOSITORY_AGGREGATE = 'repository.aggregate';

    /**
     * @param Container $container
     */
    public function register(Container $container)
    {
        $container[static::REPOSITORY_AGGREGATE] = function () use ($container) {
            $entityManager = EntityManager::create(
                $container[ConfigProvider::CONFIG_DATABASE_PARAMETERS],
                Setup::createAnnotationMetadataConfiguration(
                    [realpath(__DIR__ . '/../Entity')],
                    false,
                    null,
                    new ArrayCache()
                )
            );

            return $entityManager->getRepository('DataAggregator\Entity\Aggregate');
        };
    }
}