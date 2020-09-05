<?php declare(strict_types=1);

namespace App\Infrastructure\Common\DependencyInjection;

use App\Infrastructure\Common\Service\CommandBus;
use App\Infrastructure\Common\Service\QueryBus;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;

class ApplicationContext
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
