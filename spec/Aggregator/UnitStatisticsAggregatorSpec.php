<?php

namespace spec\DataAggregator\Aggregator;

use DataAggregator\Aggregator\DataPoint\Strategy\StrategyInterface;
use DataAggregator\Aggregator\UnitStatisticsAggregator;
use DataAggregator\Hydrator\HydratorInterface;
use DataAggregator\Repository\AggregateInterface;
use DataAggregator\Statistic\DataPoint\DataPoint;
use DataAggregator\Statistic\Metric\Metric;
use DataAggregator\Statistic\Unit\Unit;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use stdClass;

class UnitStatisticsAggregatorSpec extends ObjectBehavior
{
    function let(
        HydratorInterface $unitHydrator,
        StrategyInterface $aggregatorStrategyOne,
        StrategyInterface $aggregatorStrategyTwo,
        Unit $unitValueObject,
        Metric $metric,
        DataPoint $dataPoint,
        AggregateInterface $aggregateRepository 
    ) {
        // Arrange
        $aggregatorStrategyOne->type()->willReturn('min');
        $aggregatorStrategyTwo->type()->willReturn('max');
        $aggregatorStrategyOne->aggregate(Argument::any())->willReturn(10);
        $aggregatorStrategyTwo->aggregate(Argument::any())->willReturn(20);
        $metric->type()->willReturn('download');
        $metric->dataPoints()->willReturn([$dataPoint]);
        $metric->dataPointsForHour(Argument::any())->willReturn([$dataPoint]);
        $unitValueObject->id()->willReturn(123);
        $unitValueObject->metrics()->willReturn([$metric]);
        $unit = new stdClass();
        $unitHydrator->hydrate($unit)->willReturn($unitValueObject);

        $this->beConstructedWith($unitHydrator, $aggregateRepository, $aggregatorStrategyOne, $aggregatorStrategyTwo);
    }


    function it_can_be_constructed_with_a_unit_hydrator_and_aggregate_strategies()
    {
        // Act / Assert
        $this->shouldHaveType(UnitStatisticsAggregator::class);
    }

    function it_hydrates_the_unit_when_invoked(
        $unitHydrator
    ) {
        // Arrange
        $unit = new stdClass();

        // Act
        $this->__invoke($unit);

        // Assert
        $unitHydrator->hydrate($unit)->shouldHaveBeenCalled();
    }

    function it_calls_all_available_strategies_with_all_unit_metrics(
        HydratorInterface $unitHydrator,
        Unit $unitValueObject,
        $aggregateRepository,
        StrategyInterface $aggregatorStrategyOne,
        StrategyInterface $aggregatorStrategyTwo,
        Metric $metricDownload,
        Metric $metricUpload,
        Metric $metricLatency,
        Metric $metricPacketLoss,
        DataPoint $dataPointDownloadOne,
        DataPoint $dataPointDownloadTwo,
        DataPoint $dataPointUploadOne,
        DataPoint $dataPointUploadTwo,
        DataPoint $dataPointLatencyOne,
        DataPoint $dataPointLatencyTwo,
        DataPoint $dataPointPacketLossOne,
        DataPoint $dataPointPacketLossTwo
    ) {
        // Arrange
        $this->beConstructedWith($unitHydrator, $aggregateRepository, $aggregatorStrategyOne, $aggregatorStrategyTwo);
        $aggregatorStrategyOne->type()->willReturn('min');
        $aggregatorStrategyOne->aggregate($dataPointDownloadOne, $dataPointDownloadTwo)->willReturn(null);
        $aggregatorStrategyOne->aggregate($dataPointUploadOne, $dataPointUploadTwo)->willReturn(null);
        $aggregatorStrategyOne->aggregate($dataPointLatencyOne, $dataPointLatencyTwo)->willReturn(null);
        $aggregatorStrategyOne->aggregate($dataPointPacketLossOne, $dataPointPacketLossTwo)->willReturn(null);
        $aggregatorStrategyTwo->type()->willReturn('max');
        $aggregatorStrategyTwo->aggregate($dataPointDownloadOne, $dataPointDownloadTwo)->willReturn(null);
        $aggregatorStrategyTwo->aggregate($dataPointUploadOne, $dataPointUploadTwo)->willReturn(null);
        $aggregatorStrategyTwo->aggregate($dataPointLatencyOne, $dataPointLatencyTwo)->willReturn(null);
        $aggregatorStrategyTwo->aggregate($dataPointPacketLossOne, $dataPointPacketLossTwo)->willReturn(null);        
        $unit = new stdClass();
        $metricDownload->type()->willReturn('download');
        $metricDownload->dataPoints()->willReturn([$dataPointDownloadOne, $dataPointDownloadTwo]);
        $metricDownload->dataPointsForHour(Argument::any())->willReturn([$dataPointDownloadOne, $dataPointDownloadTwo]);
        $metricUpload->type()->willReturn('upload');
        $metricUpload->dataPoints()->willReturn([$dataPointUploadOne, $dataPointUploadTwo]);
        $metricUpload->dataPointsForHour(Argument::any())->willReturn([$dataPointUploadOne, $dataPointUploadTwo]);
        $metricLatency->type()->willReturn('latency');
        $metricLatency->dataPoints()->willReturn([$dataPointLatencyOne, $dataPointLatencyTwo]);
        $metricLatency->dataPointsForHour(Argument::any())->willReturn([$dataPointLatencyOne, $dataPointLatencyTwo]);
        $metricPacketLoss->type()->willReturn('packet_loss');
        $metricPacketLoss->dataPoints()->willReturn([$dataPointPacketLossOne, $dataPointPacketLossTwo]);
        $metricPacketLoss->dataPointsForHour(Argument::any())->willReturn([$dataPointPacketLossOne, $dataPointPacketLossTwo]);
        $unitValueObject->id()->willReturn(101);
        $unitValueObject->metrics()->willReturn([$metricDownload, $metricUpload, $metricLatency, $metricPacketLoss]);
        $unitHydrator->hydrate($unit)->willReturn($unitValueObject);
        

        // Act
        $this->__invoke($unit);

        // Assert
        $aggregatorStrategyOne->aggregate($dataPointDownloadOne, $dataPointDownloadTwo)->shouldHaveBeenCalled();
        $aggregatorStrategyOne->aggregate($dataPointUploadOne, $dataPointUploadTwo)->shouldHaveBeenCalled();
        $aggregatorStrategyOne->aggregate($dataPointLatencyOne, $dataPointLatencyTwo)->shouldHaveBeenCalled();
        $aggregatorStrategyOne->aggregate($dataPointPacketLossOne, $dataPointPacketLossTwo)->shouldHaveBeenCalled();
        $aggregatorStrategyTwo->aggregate($dataPointDownloadOne, $dataPointDownloadTwo)->shouldHaveBeenCalled();
        $aggregatorStrategyTwo->aggregate($dataPointUploadOne, $dataPointUploadTwo)->shouldHaveBeenCalled();
        $aggregatorStrategyTwo->aggregate($dataPointLatencyOne, $dataPointLatencyTwo)->shouldHaveBeenCalled();
        $aggregatorStrategyTwo->aggregate($dataPointPacketLossOne, $dataPointPacketLossTwo)->shouldHaveBeenCalled();
    }
}
