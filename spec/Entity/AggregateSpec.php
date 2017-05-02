<?php

namespace spec\DataAggregator\Entity;

use DataAggregator\Entity\Aggregate;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AggregateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Aggregate::class);
    }

    function it_throws_an_exception_when_setting_ggregate_value_if_the_name_is_invalid()
    {
        $this->shouldThrow(InvalidArgumentException::class)->during('setAggregateValue', ['foo', 10]);
    }

    function it_correctly_sets_and_exposes_the_unit_id()
    {
        $this->setUnitId(10);
        $this->getUnitId()->shouldReturn(10);
    }
    
    function it_correctly_sets_and_exposes_the_hour()
    {
        $this->setHour(12);
        $this->getHour()->shouldReturn(12);
    }
    
    function it_correctly_sets_and_exposes_the_metric()
    {
        $this->setMetric(10);
        $this->getMetric()->shouldReturn(10);
    }
    
    function it_correctly_sets_and_exposes_the_min()
    {
        $this->setAggregateValue('min', 10);
        $this->getMin()->shouldReturn(10);
    }

    function it_correctly_sets_and_exposes_the_max()
    {
        $this->setAggregateValue('max', 20);
        $this->getMax()->shouldReturn(20);
    }

    function it_correctly_sets_and_exposes_the_mean()
    {
        $this->setAggregateValue('mean', 2);
        $this->getMean()->shouldReturn(2);
    }

    function it_correctly_sets_and_exposes_the_median()
    {
        $this->setAggregateValue('median', 23.4);
        $this->getMedian()->shouldReturn(23.4);
    }

    function it_correctly_sets_and_exposes_the_total_data_points()
    {
        $this->setAggregateValue('total_data_points', 3);
        $this->getTotalDataPoints()->shouldReturn(3);
    }
}
