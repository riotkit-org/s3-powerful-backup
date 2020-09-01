<?php declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\CreateUserCommand;

class CreateUserHandler
{
    public function __invoke(CreateUserCommand $command)
    {
        dump($command);
    }
}
