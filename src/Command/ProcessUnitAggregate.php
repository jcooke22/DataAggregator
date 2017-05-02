<?php

namespace DataAggregator\Command;

use DataAggregator\Aggregator\UnitStatisticsAggregator;
use Exception;
use JsonCollectionParser\Parser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessUnitAggregate extends Command
{
    /**
     * @var string
     */
    private $inputJsonPath;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var UnitStatisticsAggregator
     */
    private $unitStatisticsAggregator;

    /**
     * ProcessUnitAggregate constructor.
     * @param null $name
     * @param string $inputJsonPath
     * @param Parser $parser
     * @param UnitStatisticsAggregator $unitStatisticsAggregator
     */
    public function __construct(
        $name = null,
        string $inputJsonPath,
        Parser $parser,
        UnitStatisticsAggregator $unitStatisticsAggregator
    ) {
        $this->inputJsonPath = $inputJsonPath;
        $this->parser = $parser;
        $this->unitStatisticsAggregator = $unitStatisticsAggregator;
        parent::__construct($name);
    }


    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('Unit:ProcessAggregate');
        $this->setDescription('Process a JSON file of unit data into a queryable aggregate');
        $this->setHelp('This command will process the JSON file and populate the aggregate database');
    }

    /**
     * Exceptions are not caught as the Symfony Console handles exceptions gracefully.
     * 
     * @inheritdoc
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->parser->parse(
            $this->inputJsonPath,
            $this->unitStatisticsAggregator,
            false
        );
        
        $output->writeln("Unit data successfully aggregated.");
        
        return $output;
    }

}
