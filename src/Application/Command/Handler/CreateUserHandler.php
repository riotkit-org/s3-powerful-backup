<?php declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\CreateUserCommand;
use App\Domain\Users\Repository\UserRepositoryInterface;
use App\Domain\Users\WriteModel\User;

class CreateUserHandler
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateUserCommand $command)
    {
        $user = User::fromArray($command->toArray(), 'some-salt-@todo-change', 90000);

        $this->repository->persist();
        $this->repository->flush();

        dump($command);
    }
}
