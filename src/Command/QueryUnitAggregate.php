<?php

namespace DataAggregator\Command;

use DataAggregator\Aggregator\UnitStatisticsAggregator;
use DataAggregator\Repository\AggregateInterface;
use Exception;
use JsonCollectionParser\Parser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueryUnitAggregate extends Command
{
    /**
     * @var AggregateInterface
     */
    private $aggregateRepository;

    /**
     * QueryUnitAggregate constructor.
     * @param null $name
     * @param AggregateInterface $aggregateRepository
     */
    public function __construct(
        $name = null,
        AggregateInterface $aggregateRepository
    ) {
        $this->aggregateRepository = $aggregateRepository;
        parent::__construct($name);
    }


    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('Unit:QueryAggregate');
        $this->setDescription('Query the unit aggregate data.');
        $this->setHelp(
            'This command expects three arguments: unitId, metric (download, upload, latency, or packet_loss), and hour'
        );
        $this->addArgument('unitId', InputArgument::REQUIRED, 'Which unit would you like to query?');
        $this->addArgument('metric', InputArgument::REQUIRED, 'Which metric would you like to query?');
        $this->addArgument('hour', InputArgument::REQUIRED, 'Which hour of the day would you like to query?');
    }

    /**
     * Exceptions are not caught as the Symfony Console handles exceptions gracefully.
     *
     * @inheritdoc
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (!in_array($input->getArgument('metric'), ['download', 'upload', 'latency', 'packet_loss'])) {
            throw new InvalidArgumentException(
                sprintf('Invalid metric supplied: %s', $input->getArgument('metric'))
            );
        }

        $aggregate = $this->aggregateRepository->findByUnitIdHourMetric(
            (int)$input->getArgument('unitId'),
            (int)$input->getArgument('hour'),
            (string)$input->getArgument('metric')
        );

        $table = new Table($output);
        $table
            ->setHeaders(
                [
                    'Unit ID',
                    'Metric',
                    'Hour',
                    'Min',
                    'Max',
                    'Mean',
                    'Median',
                    'Total Data Points',

                ]
            )
            ->setRows(
                [
                    [
                        $aggregate->getUnitId(),
                        $aggregate->getMetric(),
                        $aggregate->getHour(),
                        $aggregate->getMin(),
                        $aggregate->getMax(),
                        $aggregate->getMean(),
                        $aggregate->getMedian(),
                        $aggregate->getTotalDataPoints(),

                    ],
                ]
            );
        $table->render();

        return $output;
    }

}
