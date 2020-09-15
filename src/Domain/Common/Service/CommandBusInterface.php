<?php declare(strict_types=1);

namespace App\Domain\Common\Service;

interface CommandBusInterface
{
    public function handle($command): void;
}
