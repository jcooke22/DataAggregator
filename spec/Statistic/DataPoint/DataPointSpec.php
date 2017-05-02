<?php

namespace spec\DataAggregator\Statistic\DataPoint;

use DataAggregator\Statistic\DataPoint\DataPoint;
use DataAggregator\Statistic\DataPoint\DataPointInterface;
use DateTime;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DataPointSpec extends ObjectBehavior
{
    function it_implements_the_correct_interface()
    {
        // Arrange / Act
        $this->beConstructedWith('2017-02-10 17:00:00', '123');

        // Assert
        $this->shouldImplement(DataPointInterface::class);
    }

    function it_can_be_constructed_with_a_timestamp_and_a_value()
    {
        // Arrange / Act
        $this->beConstructedWith('2017-02-10 17:00:00', '123');

        // Assert
        $this->shouldHaveType(DataPoint::class);
    }

    function it_throws_an_exception_if_the_timespamp_is_invalid()
    {
        // Arrange / Act
        $this->beConstructedWith('foo', '123');

        // Assert
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_throws_an_exception_if_the_value_is_not_numeric()
    {
        // Arrange / Act
        $this->beConstructedWith('2017-02-10 17:00:00', 'foo');

        // Assert
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_exposes_the_timestamp_as_a_date_time_object()
    {
        // Arrange / Act
        $this->beConstructedWith('2017-02-10 17:00:00', '123');

        // Assert
        $this->timestamp()->shouldHaveType(DateTime::class);
    }

    function it_exposes_the_timestamp_as_a_date_time_object_with_the_correct_time()
    {
        // Arrange / Act
        $this->beConstructedWith('2017-04-29 14:08:00', '123');

        // Assert
        $this->timestamp()->getTimestamp()->shouldReturn(1493474880);
    }

    function it_exposes_the_correct_value()
    {
        // Arrange / Act
        $this->beConstructedWith('2017-04-29 14:08:00', 123);

        // Assert
        $this->value()->shouldReturn(123);
    }


}
