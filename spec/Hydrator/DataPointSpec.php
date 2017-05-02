<?php

namespace spec\DataAggregator\Hydrator;

use DataAggregator\Exception\HydratorException;
use DataAggregator\Hydrator\DataPoint;
use DataAggregator\Hydrator\HydratorInterface;
use DateTime;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use stdClass;

class DataPointSpec extends ObjectBehavior
{
    public function getMatchers()
    {
        return [
            'haveTheCorrectValue' => function ($subject, $expectedValue) {
                return $subject->value() === $expectedValue;
            },
            'haveTheCorrectTimestamp' => function ($subject, $expectedTimestamp) {
                return $subject->timestamp() == $expectedTimestamp;
            },
        ];
    }

    function it_implements_the_correct_interface()
    {
        // Act / Assert
        $this->shouldHaveType(HydratorInterface::class);
    }

    function it_throws_an_exception_if_the_data_is_not_an_object()
    {
        // Arrange / Act / Assert
        $this->shouldThrow(InvalidArgumentException::class)->during('hydrate', [[]]);
    }

    function it_throws_an_exception_if_the_timestamp_is_not_set()
    {
        // Arrange
        $data = new stdClass();
        $data->value = 11;

        // Act / Assert
        $this->shouldThrow(InvalidArgumentException::class)->during('hydrate', [$data]);
    }

    function it_throws_an_exception_if_the_value_is_not_set()
    {
        // Arrange
        $data = new stdClass();
        $data->timestamp = '2017-02-10 17:00:00';

        // Act / Assert
        $this->shouldThrow(InvalidArgumentException::class)->during('hydrate', [$data]);
    }

    function it_throws_an_exception_if_the_data_point_cannot_be_created()
    {
        // Arrange
        $data = new stdClass();
        $data->timestamp = 'foo';
        $data->value = 123;

        // Act / Assert
        $this->shouldThrow(HydratorException::class)->during('hydrate', [$data]);
    }

    function it_hydrates_a_datapoint_with_the_correct_data()
    {
        // Arrange
        $data = new stdClass();
        $data->timestamp = '2017-02-10 17:00:00';
        $data->value = 123;

        // Act / Assert
        $this->hydrate($data)->shouldHaveTheCorrectValue(123);
        $this->hydrate($data)->shouldHaveTheCorrectTimestamp(new DateTime('2017-02-10 17:00:00'));
    }
}
