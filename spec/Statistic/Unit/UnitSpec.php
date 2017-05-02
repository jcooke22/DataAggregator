<?php

namespace spec\DataAggregator\Statistic\Unit;

use DataAggregator\Statistic\Metric\Metric;
use DataAggregator\Statistic\Unit\Unit;
use DataAggregator\Statistic\Unit\UnitInterface;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UnitSpec extends ObjectBehavior
{
    function it_can_be_constructed_with_id_and_metrics(
        Metric $metricOne,
        Metric $metricTwo
    ) {
        // Arrange / Act
        $this->beConstructedWith(10, $metricOne, $metricTwo);

        // Assert
        $this->shouldHaveType(Unit::class);
    }

    function it_implements_the_correct_interface(
        Metric $metricOne,
        Metric $metricTwo
    ) {
        // Arrange / Act
        $this->beConstructedWith(10, $metricOne, $metricTwo);

        // Assert
        $this->shouldImplement(UnitInterface::class);
    }

    function it_throws_an_exception_if_no_metrics_are_supplied()
    {
        // Arrange / Act
        $this->beConstructedWith(10);

        // Assert
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_exposes_id(
        Metric $metricOne,
        Metric $metricTwo
    ) {
        // Arrange / Act
        $this->beConstructedWith(10, $metricOne, $metricTwo);

        // Assert
        $this->id()->shouldReturn(10);
    }

    function it_exposes_metrics(
        Metric $metricOne,
        Metric $metricTwo
    ) {
        // Arrange / Act
        $this->beConstructedWith(10, $metricOne, $metricTwo);

        // Assert
        $this->metrics()->shouldReturn([$metricOne, $metricTwo]);
    }

}
