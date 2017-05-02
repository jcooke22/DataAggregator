<?php

namespace spec\DataAggregator\Aggregator\DataPoint\Strategy;

use DataAggregator\Aggregator\DataPoint\Strategy\Max;
use DataAggregator\Aggregator\DataPoint\Strategy\StrategyInterface;
use DataAggregator\Statistic\DataPoint\DataPoint;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MaxSpec extends ObjectBehavior
{
    function it_implements_the_correct_interface()
    {
        // Assert
        $this->shouldImplement(StrategyInterface::class);
    }

    function it_exposes_the_correct_type()
    {
        // Act / Assert
        $this->type()->shouldReturn('max');
    }

    function it_throws_an_exception_if_no_data_points_are_supplied()
    {
        // Act / Assert
        $this->shouldThrow(InvalidArgumentException::class)->during('aggregate', []);
    }

    function it_returns_the_correct_max_for_integers(
        DataPoint $dataPointOne,
        DataPoint $dataPointTwo,
        DataPoint $dataPointThree
    ) {
        // Arrange
        $dataPointOne->value()->willReturn(10);
        $dataPointTwo->value()->willReturn(20);
        $dataPointThree->value()->willReturn(30);

        // Act / Assert
        $this->aggregate($dataPointOne, $dataPointTwo, $dataPointThree)->shouldReturn(30);
    }

    function it_returns_the_correct_max_for_floats(
        DataPoint $dataPointOne,
        DataPoint $dataPointTwo,
        DataPoint $dataPointThree
    ) {
        // Arrange
        $dataPointOne->value()->willReturn(1.6);
        $dataPointTwo->value()->willReturn(0.4);
        $dataPointThree->value()->willReturn(1.8);

        // Act / Assert
        $this->aggregate($dataPointOne, $dataPointTwo, $dataPointThree)->shouldReturn(1.8);
    }
}