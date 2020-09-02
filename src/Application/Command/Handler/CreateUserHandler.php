<?php declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\CreateUserCommand;

class CreateUserHandler
{
    public function __invoke(CreateUserCommand $command)
    {
        dump($command);
    }
}
