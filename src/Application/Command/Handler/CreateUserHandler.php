<?php declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\CreateUserCommand;
use App\Domain\Common\Exception\ValidationConstraintViolatedException;
use App\Domain\Common\Exception\ValidationException;
use App\Domain\Users\Exception\UserCreationException;
use App\Domain\Users\Repository\UserRepositoryInterface;
use App\Domain\Users\WriteModel\User;

class CreateUserHandler
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param CreateUserCommand $command
     *
     * @throws UserCreationException
     * @throws ValidationException
     */
    public function __invoke(CreateUserCommand $command)
    {
        $user = User::fromArray($command->toArray(), 'some-salt-@todo-change', 90000);

        if ($this->repository->findUserByEmailAddress($user->getEmail()->getValue())) {
            throw UserCreationException::causeUserAlreadyExists();
        }

        $this->repository->persist($user);
        $this->repository->flush();

        dump($command);
    }
}
