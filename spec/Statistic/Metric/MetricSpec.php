<?php

namespace spec\DataAggregator\Statistic\Metric;

use DataAggregator\Statistic\DataPoint\DataPointInterface;
use DataAggregator\Statistic\Metric\Metric;
use DataAggregator\Statistic\Metric\MetricInterface;
use DateTime;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MetricSpec extends ObjectBehavior
{
    function it_can_be_constructed_with_a_type_and_datapoints(
        DataPointInterface $dataPointOne,
        DataPointInterface $dataPointTwo

    ) {
        // Arrange / Act
        $this->beConstructedWith('download', $dataPointOne, $dataPointTwo);

        // Assert
        $this->shouldHaveType(Metric::class);
    }

    function it_implements_the_correct_interface(
        DataPointInterface $dataPointOne,
        DataPointInterface $dataPointTwo

    ) {
        // Arrange / Act
        $this->beConstructedWith('download', $dataPointOne, $dataPointTwo);

        // Assert
        $this->shouldImplement(MetricInterface::class);
    }

    function it_throws_an_exception_if_no_datapoints_are_passed()
    {
        // Arrange
        $this->beConstructedWith('download');

        // Act / Assert
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_exposes_type(
        DataPointInterface $dataPointOne,
        DataPointInterface $dataPointTwo

    ) {
        // Arrange / Act
        $this->beConstructedWith('download', $dataPointOne, $dataPointTwo);

        // Assert
        $this->type()->shouldReturn('download');
    }

    function it_exposes_data_points(
        DataPointInterface $dataPointOne,
        DataPointInterface $dataPointTwo

    ) {
        // Arrange / Act
        $this->beConstructedWith('download', $dataPointOne, $dataPointTwo);

        // Assert
        $this->dataPoints()->shouldReturn([$dataPointOne, $dataPointTwo]);
    }
    
    function it_exposes_data_for_a_specific_hour(
        DataPointInterface $dataPointOne,
        DataPointInterface $dataPointTwo,
        DataPointInterface $dataPointThree,
        DataPointInterface $dataPointFour

    ) {
        // Arrange / Act
        $dataPointOne->timestamp()->willReturn(new DateTime('2017-02-10 13:00:00'));
        $dataPointTwo->timestamp()->willReturn(new DateTime('2017-02-10 13:00:00'));
        $dataPointThree->timestamp()->willReturn(new DateTime('2017-02-10 14:00:00'));
        $dataPointFour->timestamp()->willReturn(new DateTime('2017-02-10 15:00:00'));
        $this->beConstructedWith('download', $dataPointOne, $dataPointTwo, $dataPointThree, $dataPointFour);

        // Assert
        $this->dataPointsForHour(13)->shouldReturn([$dataPointOne, $dataPointTwo]);
    }


}
