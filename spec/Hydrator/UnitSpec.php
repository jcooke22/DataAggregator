<?php

namespace spec\DataAggregator\Hydrator;

use DataAggregator\Hydrator\HydratorInterface;
use DataAggregator\Hydrator\Metric;
use DataAggregator\Hydrator\Unit;
use DataAggregator\Statistic\Metric\Metric as MetricValueObject;
use DataAggregator\Statistic\Unit\Unit as UnitValueObject;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use stdClass;

class UnitSpec extends ObjectBehavior
{
    public function getMatchers()
    {
        return [
            'returnTheCorrectUnitInstance' => function ($subject, $data, $expectedCount) {
                if (!$subject instanceof UnitValueObject) {
                    return false;
                }
                if (!count($subject->metrics()) == $expectedCount) {
                    return false;
                }
                return true;
            }
        ];
    }


    function let(Metric $metricHydrator)
    {
        // Arrange
        $this->beConstructedWith($metricHydrator);
    }

    function it_should_be_constructed_with_a_metric_hydrator()
    {
        // Act / Assert
        $this->shouldHaveType(Unit::class);
    }

    function it_implements_the_correct_interface()
    {
        // Act / Assert
        $this->shouldImplement(HydratorInterface::class);
    }

    function it_throws_an_exception_if_the_data_is_not_an_object()
    {
        // Act / Assert
        $this->shouldThrow(InvalidArgumentException::class)->during('hydrate', [[]]);
    }

    function it_throws_an_exception_if_the_unit_id_is_not_set(
        MetricValueObject $metric
    ) {
        // Arrange
        $data = new stdClass();
        $data->metrics = [$metric];

        // Act / Assert
        $this->shouldThrow(InvalidArgumentException::class)->during('hydrate', [$data]);
    }

    function it_throws_an_exception_if_the_metrics_are_not_set()
    {
        // Arrange
        $data = new stdClass();
        $data->unit_id = 123;

        // Act / Assert
        $this->shouldThrow(InvalidArgumentException::class)->during('hydrate', [$data]);
    }

    function it_returns_a_unit_value_object_with_the_correct_metrics(
        MetricValueObject $metric,
        Metric $metricHydrator
    ) {
        // Arrange
        $metricHydrator->hydrate(Argument::any())->willReturn([$metric]);
        $data = new stdClass();
        $data->unit_id = 123;
        $data->metrics = [$metric];

        // Act / Assert
        $this->hydrate($data)->shouldReturnTheCorrectUnitInstance($data, 1);
    }
}
