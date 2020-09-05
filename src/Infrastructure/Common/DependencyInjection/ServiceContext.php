<?php declare(strict_types=1);

namespace App\Infrastructure\Common\DependencyInjection;

use App\Infrastructure\Common\Service\CommandBus;
use App\Infrastructure\Common\Service\QueryBus;
use JMS\Serializer\SerializerInterface;

class ServiceContext
{
    public SerializerInterface $serializer;
    public CommandBus          $commandBus;
    public QueryBus            $queryBus;

    public function __construct(SerializerInterface $serializer, CommandBus $cBus, QueryBus $qBus)
    {
        $this->serializer = $serializer;
        $this->commandBus = $cBus;
        $this->queryBus   = $qBus;
    }
}
