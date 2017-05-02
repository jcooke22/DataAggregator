<?php

namespace spec\DataAggregator\Aggregator\DataPoint\Strategy;

use DataAggregator\Aggregator\DataPoint\Strategy\Count;
use DataAggregator\Aggregator\DataPoint\Strategy\StrategyInterface;
use DataAggregator\Statistic\DataPoint\DataPoint;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CountSpec extends ObjectBehavior
{
    function it_implements_the_correct_interface()
    {
        // Assert
        $this->shouldImplement(StrategyInterface::class);
    }

    function it_exposes_the_correct_type()
    {
        // Act / Assert
        $this->type()->shouldReturn('total_data_points');
    }

    function it_returns_the_correct_count(
        DataPoint $dataPointOne,
        DataPoint $dataPointTwo,
        DataPoint $dataPointThree
    ) {
        // Act / Assert
        $this->aggregate($dataPointOne, $dataPointTwo, $dataPointThree)->shouldReturn(3);
    }
}
