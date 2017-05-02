<?php

namespace DataAggregator\Statistic\DataPoint;

use DateTime;

interface DataPointInterface
{
    public function timestamp(): DateTime;
    public function value();
}
