<?php

use DataAggregator\Application;

require_once dirname(__FILE__) . '/vendor/autoload.php';

$application = new Application();
$application->run();