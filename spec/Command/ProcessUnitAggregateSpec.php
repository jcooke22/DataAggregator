<?php

namespace spec\DataAggregator\Command;

use DataAggregator\Aggregator\UnitStatisticsAggregator;
use DataAggregator\Command\ProcessUnitAggregate;
use JsonCollectionParser\Parser;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessUnitAggregateSpec extends ObjectBehavior
{
    function let(
        Parser $parser,
        UnitStatisticsAggregator $unitStatisticsAggregator
    ) {
        $this->beConstructedWith(
            'Unit:ProcessAggregate',
            '/some/path/to/test.json',
            $parser,
            $unitStatisticsAggregator
        );
    }


    function it_extends_command()
    {
        // Assert
        $this->shouldHaveType(Command::class);
    }

    function it_exposes_the_command_name()
    {
        // Act / Assert
        $this->getName()->shouldReturn('Unit:ProcessAggregate');
    }

    function it_exposes_the_command_description()
    {
        // Act / Assert
        $this->getDescription()->shouldReturn('Process a JSON file of unit data into a queryable aggregate');
    }

    function it_exposes_the_command_help()
    {
        // Act / Assert
        $this->getHelp()->shouldReturn('This command will process the JSON file and populate the aggregate database');
    }

    function it_returns_an_output_object_from_an_input_object(
        InputInterface $input,
        OutputInterface $output
    ) {
        // Act / Assert
        $this->execute($input, $output)->shouldImplement(OutputInterface::class);
    }

    function it_returns_an_output_object_with_a_success_message(
        InputInterface $input,
        OutputInterface $output
    ) {
        // Act
        $this->execute($input, $output);

        // Assert
        $output->writeln("Unit data successfully aggregated.")->shouldHaveBeenCalled();
    }

    function it_aggregates_the_unit_data_by_triggering_the_parser(
        $parser,
        $unitStatisticsAggregator,
        InputInterface $input,
        OutputInterface $output

    ) {
        // Act
        $this->execute($input, $output);

        // Assert
        $parser->parse(
            '/some/path/to/test.json',
            $unitStatisticsAggregator,
            false
        )->shouldHaveBeenCalled();
    }
    
}
