<?php declare(strict_types=1);

namespace App\Infrastructure\Common\Service;

use App\Domain\Common\Service\CommandBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus implements CommandBusInterface
{
    protected MessageBusInterface $parent;

    public function __construct(MessageBusInterface $bus)
    {
        $this->parent = $bus;
    }

    public function handle($command): void
    {
        $this->parent->dispatch($command);
    }
}
