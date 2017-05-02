<?php

namespace DataAggregator\Hydrator;

/**
 * Interface HydratorInterface.
 */
interface HydratorInterface
{
    /**
     * @param mixed $data
     *
     * @return mixed
     */
    public function hydrate($data);
}
