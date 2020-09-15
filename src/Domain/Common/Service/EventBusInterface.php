<?php declare(strict_types=1);

namespace App\Domain\Common\Service;

interface EventBusInterface
{
    public function emit($command): void;
}
