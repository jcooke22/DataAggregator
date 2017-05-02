<?php

namespace spec\DataAggregator\Aggregator\DataPoint\Strategy;

use DataAggregator\Aggregator\DataPoint\Strategy\Median;
use DataAggregator\Aggregator\DataPoint\Strategy\StrategyInterface;
use DataAggregator\Statistic\DataPoint\DataPoint;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MedianSpec extends ObjectBehavior
{
    function it_implements_the_correct_interface()
    {
        // Assert
        $this->shouldImplement(StrategyInterface::class);
    }

    function it_exposes_the_correct_type()
    {
        // Act / Assert
        $this->type()->shouldReturn('median');
    }

    function it_returns_the_correct_median_for_integers_simple(
        DataPoint $dataPointOne,
        DataPoint $dataPointTwo,
        DataPoint $dataPointThree
    ) {
        // Arrange
        $dataPointOne->value()->willReturn(100);
        $dataPointTwo->value()->willReturn(200);
        $dataPointThree->value()->willReturn(300);

        // Act / Assert
        $this->aggregate($dataPointOne, $dataPointTwo, $dataPointThree)->shouldReturn(200);
    }

    function it_returns_the_correct_median_for_integers_complex(
        DataPoint $dataPointOne,
        DataPoint $dataPointTwo,
        DataPoint $dataPointThree,
        DataPoint $dataPointFour
    ) {
        // Arrange
        $dataPointOne->value()->willReturn(100);
        $dataPointTwo->value()->willReturn(200);
        $dataPointThree->value()->willReturn(300);
        $dataPointFour->value()->willReturn(400);

        // Act / Assert
        $this->aggregate($dataPointOne, $dataPointTwo, $dataPointThree, $dataPointFour)->shouldReturn(250);
    }

    function it_returns_the_correct_median_for_floats_simple(
        DataPoint $dataPointOne,
        DataPoint $dataPointTwo,
        DataPoint $dataPointThree
    ) {
        // Arrange
        $dataPointOne->value()->willReturn(12.6);
        $dataPointTwo->value()->willReturn(41.2);
        $dataPointThree->value()->willReturn(78.3);

        // Act / Assert
        $this->aggregate($dataPointOne, $dataPointTwo, $dataPointThree)->shouldReturn(41.2);
    }
    
    function it_returns_the_correct_median_for_floats_complex(
        DataPoint $dataPointOne,
        DataPoint $dataPointTwo,
        DataPoint $dataPointThree,
        DataPoint $dataPointFour
    ) {
        // Arrange
        $dataPointOne->value()->willReturn(12.6);
        $dataPointTwo->value()->willReturn(41.2);
        $dataPointThree->value()->willReturn(78.3);
        $dataPointFour->value()->willReturn(101.2);

        // Act / Assert
        $this->aggregate($dataPointOne, $dataPointTwo, $dataPointThree, $dataPointFour)->shouldReturn(59.75);
    }
}
