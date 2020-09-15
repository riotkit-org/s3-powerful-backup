<?php declare(strict_types=1);

namespace App\Infrastructure\Common\Service;

use App\Domain\Common\Service\EventBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class EventBus implements EventBusInterface
{
    protected MessageBusInterface $parent;

    public function __construct(MessageBusInterface $bus)
    {
        $this->parent = $bus;
    }

    public function emit($command): void
    {
        $this->parent->dispatch($command)->getMessage();
    }
}
