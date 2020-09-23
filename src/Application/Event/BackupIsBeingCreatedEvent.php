<?php declare(strict_types=1);

namespace App\Application\Event;

class BackupIsBeingCreatedEvent
{
    public string $maxAllVersionsSize;
    public string $oneVersionSize;

    public function __construct(string $maxAllVersionsSize, string $oneVersionSize)
    {
        $this->maxAllVersionsSize = $maxAllVersionsSize;
        $this->oneVersionSize     = $oneVersionSize;
    }
}
