<?php

namespace spec\DataAggregator\Aggregator\DataPoint\Strategy;

use DataAggregator\Aggregator\DataPoint\Strategy\Mean;
use DataAggregator\Aggregator\DataPoint\Strategy\StrategyInterface;
use DataAggregator\Statistic\DataPoint\DataPoint;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MeanSpec extends ObjectBehavior
{
    function it_implements_the_correct_interface()
    {
        // Assert
        $this->shouldImplement(StrategyInterface::class);
    }

    function it_exposes_the_correct_type()
    {
        // Act / Assert
        $this->type()->shouldReturn('mean');
    }

    function it_returns_the_correct_mean(
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
}
