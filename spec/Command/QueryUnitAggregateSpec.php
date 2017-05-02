<?php

namespace spec\DataAggregator\Command;

use DataAggregator\Command\QueryUnitAggregate;
use DataAggregator\Entity\Aggregate;
use DataAggregator\Repository\AggregateInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueryUnitAggregateSpec extends ObjectBehavior
{
    public function getMatchers()
    {
        return [
            'haveTheArguments' => function ($subject, array $requiredArguments) {
                foreach ($requiredArguments as $requiredArgument) {
                    if (!isset($subject[$requiredArgument])) {
                        return false;
                    }
                }
                return true;
            },
        ];
    }

    function let(AggregateInterface $aggregateRepository)
    {
        $this->beConstructedWith(null, $aggregateRepository);
    }

    function it_extends_command()
    {
        // Assert
        $this->shouldHaveType(Command::class);
    }

    function it_exposes_the_command_name()
    {
        // Act / Assert
        $this->getName()->shouldReturn('Unit:QueryAggregate');
    }

    function it_exposes_the_command_description()
    {
        // Act / Assert
        $this->getDescription()->shouldReturn('Query the unit aggregate data.');
    }

    function it_exposes_the_command_help()
    {
        // Act / Assert
        $this->getHelp()->shouldReturn(
            'This command expects three arguments: unitId, metric (download, upload, latency, or packet_loss), and hour'
        );
    }

    function it_sets_the_arguments_correctly()
    {
        $this->getDefinition()->getArguments()->shouldHaveTheArguments(['unitId', 'metric', 'hour']);
    }

    function it_returns_an_output_object_from_an_input_object(
        InputInterface $input,
        OutputInterface $output,
        $aggregateRepository,
        Aggregate $aggregateEntity,
        OutputFormatterInterface $outputFormatter
    ) {
        // Arrange
        $output->getFormatter()->willReturn($outputFormatter);
        $output->writeln(Argument::any())->willReturn(null);
        
        $aggregateRepository->findByUnitIdHourMetric(1, 12, 'download')->willReturn($aggregateEntity);
        
        $input->getArgument('unitId')->willReturn('1');
        $input->getArgument('metric')->willReturn('download');
        $input->getArgument('hour')->willReturn('12');
        
        // Act / Assert
        $this->execute($input, $output)->shouldImplement(OutputInterface::class);
        $aggregateRepository->findByUnitIdHourMetric(1, 12, 'download')->shouldHaveBeenCalled();
        $output->writeln(Argument::any())->shouldHaveBeenCalled();
    }

    function it_throws_an_exception_if_the_metric_is_invalid(
        InputInterface $input,
        OutputInterface $output
    )
    {
        // Arrange
        $input->getArgument('metric')->willReturn('foo');
        
        // Act / Assert
        $this->shouldThrow(InvalidArgumentException::class)->during('execute', [$input, $output]);
    }
}
