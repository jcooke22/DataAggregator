<?php

namespace DataAggregator;

use DataAggregator\Providers\CommandProvider;
use DataAggregator\Providers\ConfigProvider;
use DataAggregator\Providers\RepositoryProvider;
use Dotenv\Dotenv;
use Pimple\Container;
use Symfony\Component\Console\Application as ConsoleApplication;

class Application
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var ConsoleApplication
     */
    private $consoleApplication;

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->initEnvironmentVariables();
        $this->initContainer();
        $this->initConsole();
    }

    /**
     * Run the application
     */
    public function run()
    {
        $this->consoleApplication->run();
    }

    /**
     * Init container
     */
    private function initContainer()
    {
        $this->container = new Container();
        $this->container->register(new ConfigProvider());
        $this->container->register(new RepositoryProvider());
        $this->container->register(new CommandProvider());
    }

    /**
     * Init console
     */
    private function initConsole()
    {
        $this->consoleApplication = new ConsoleApplication();
        $this->consoleApplication->add($this->container[CommandProvider::COMMAND_PROCESS_UNIT_AGGREGATE]);
        $this->consoleApplication->add($this->container[CommandProvider::COMMAND_QUERY_UNIT_AGGREGATE]);
    }

    /**
     * Init environment variables
     */
    private function initEnvironmentVariables()
    {
        $dotenv = new Dotenv(__DIR__ . '/../');
        $dotenv->load();
        $dotenv->required('UNIT_AGGREGATE_MYSQL_HOST')->notEmpty();
        $dotenv->required('UNIT_AGGREGATE_MYSQL_USER')->notEmpty();
        $dotenv->required('UNIT_AGGREGATE_MYSQL_PASSWORD');
        $dotenv->required('UNIT_AGGREGATE_MYSQL_DATABASE_NAME')->notEmpty();
    }
}