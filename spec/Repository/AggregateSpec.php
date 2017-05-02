<?php

namespace spec\DataAggregator\Repository;

use DataAggregator\Exception\RepositoryException;
use DataAggregator\Repository\Aggregate;
use DataAggregator\Repository\AggregateInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query;
use Exception;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AggregateSpec extends ObjectBehavior
{
    function let(EntityManagerInterface $entityManager, ClassMetadata $classMetadata)
    {
        // Arrange
        $this->beConstructedWith($entityManager, $classMetadata);
    }

    function it_implements_the_correct_interface()
    {
        // Assert
        $this->shouldImplement(AggregateInterface::class);
    }

    function it_extends_entity_repository()
    {
        // Assert
        $this->shouldHaveType(EntityRepository::class);
    }

    function it_throws_an_exception_if_the_query_fails($entityManager)
    {
        // Arrange
        $entityManager->createQuery(Argument::any())->willThrow(Exception::class);
        
        // Act / Assert
        $this
            ->shouldThrow(RepositoryException::class)
            ->during('findByUnitIdHourMetric', [1, 12, 'download']);

    }
    
    // @todo - Mock the Doctrine Entity Manager to test:
    // @todo : That returning null throws a RepositoryException
    // @todo : That the method returns an instance of AggregateLookupEntity
}
