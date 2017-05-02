<?php

namespace spec\DataAggregator\Hydrator;

use DataAggregator\Hydrator\DataPoint;
use DataAggregator\Hydrator\HydratorInterface;
use DataAggregator\Hydrator\Metric;
use DataAggregator\Statistic\DataPoint\DataPoint as DataPointValueObject;
use InvalidArgumentException;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use stdClass;
use Traversable;

class MetricSpec extends ObjectBehavior
{
    public function getMatchers()
    {
        return [
            'throwInvalidArgumentExceptionWithinGenerator' => function ($subject, $data) {
                try {
                    foreach ($this->getWrappedObject()->hydrate($data) as $metric) {
                    }
                    return false;
                } catch (InvalidArgumentException $e) {
                    return true;
                }
            },
            'yieldTheCorrectInstancesOfMetricValueObjects' => function ($subject, $data, $expectedMetricCount) {
                $count = 0;
                foreach ($this->getWrappedObject()->hydrate($data) as $metric) {
                    $count++;
                }
                if ($count != $expectedMetricCount) {
                    return false;
                }
                return true;
            }
        ];
    }

    function let(
        DataPoint $dataPointHydrator
    ) {
        // Arrange
        $this->beConstructedWith($dataPointHydrator);
    }

    function it_can_be_constructed_with_a_datapoint_hydrator()
    {
        // Act / Assert
        $this->shouldHaveType(Metric::class);
    }

    function it_implements_the_correct_interface(
        DataPoint $dataPointHydrator
    ) {
        // Arrange
        $this->beConstructedWith($dataPointHydrator);

        // Act / Assert
        $this->shouldImplement(HydratorInterface::class);
    }

    function it_throws_an_exception_if_the_data_is_not_an_object()
    {
        // Arrange / Act / Assert
        $this->shouldThrowInvalidArgumentExceptionWithinGenerator([]);
    }

    function it_throws_an_exception_if_the_data_object_is_missing_download_of_download_is_not_an_array()
    {
        // Arrange
        $data = new stdClass();
        $data->upload = [];
        $data->latency = [];
        $data->packet_loss = [];

        // Act / Assert
        $this->shouldThrowInvalidArgumentExceptionWithinGenerator($data);
    }

    function it_throws_an_exception_if_the_data_object_is_missing_upload_of_upload_is_not_an_array()
    {
        // Arrange
        $data = new stdClass();
        $data->download = [];
        $data->latency = [];
        $data->packet_loss = [];

        // Act / Assert
        $this->shouldThrowInvalidArgumentExceptionWithinGenerator($data);
    }

    function it_throws_an_exception_if_the_data_object_is_missing_latency_of_latency_is_not_an_array()
    {
        // Arrange
        $data = new stdClass();
        $data->download = [];
        $data->upload = [];
        $data->packet_loss = [];

        // Act / Assert
        $this->shouldThrowInvalidArgumentExceptionWithinGenerator($data);
    }

    function it_throws_an_exception_if_the_data_object_is_missing_packet_loss_of_packet_loss_is_not_an_array()
    {
        // Arrange
        $data = new stdClass();
        $data->download = [];
        $data->upload = [];
        $data->latency = [];

        // Act / Assert
        $this->shouldThrowInvalidArgumentExceptionWithinGenerator($data);
    }

    function it_yields_the_correct_instances_of_metric_value_objects_as_a_generator(
        DataPoint $dataPointHydrator,
        DataPointValueObject $dataPoint
    ) {
        // Arrange
        $dataPointHydrator->hydrate(Argument::any())->willReturn($dataPoint);
        $dataPointPrototype = new stdClass();
        $dataPointPrototype->timestamp = "2017-02-10 17:00:00";
        $dataPointPrototype->value = 100;
        $data = new stdClass();
        $data->download = [clone $dataPointPrototype];
        $data->upload = [clone $dataPointPrototype];
        $data->latency = [clone $dataPointPrototype];
        $data->packet_loss = [clone $dataPointPrototype];

        // Act / Assert
        $this->shouldYieldTheCorrectInstancesOfMetricValueObjects($data, 4);
    }


}
