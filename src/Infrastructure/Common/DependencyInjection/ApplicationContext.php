<?php declare(strict_types=1);

namespace App\Infrastructure\Common\DependencyInjection;

use App\Domain\Common\Service\CommandBusInterface;
use App\Domain\Common\Service\EventBusInterface;
use App\Domain\Common\Service\QueryBusInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;

class ApplicationContext
{
    public SerializerInterface $serializer;
    public CommandBusInterface $commandBus;
    public QueryBusInterface   $queryBus;
    public EventBusInterface   $eventBus;

    public function __construct(SerializerInterface $serializer, CommandBusInterface $cBus, QueryBusInterface $qBus, EventBusInterface $eBus)
    {
        $this->serializer = $serializer;
        $this->commandBus = $cBus;
        $this->queryBus   = $qBus;
        $this->eventBus   = $eBus;
    }

    /**
     * Executes a command basing on JSON input from Request
     *
     * @param Request $request
     * @param string $commandClassName
     *
     * @return mixed
     */
    public function handleCommand(Request $request, string $commandClassName)
    {
        $command = $this->serializer->deserialize($request->getContent(), $commandClassName, 'json');
        $this->commandBus->handle($command);

        return $command;
    }
}
