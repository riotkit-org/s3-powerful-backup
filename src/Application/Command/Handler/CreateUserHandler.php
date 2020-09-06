<?php declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\CreateUserCommand;
use App\Domain\Common\Exception\ValidationException;
use App\Domain\Common\Service\WriteModelPersister;
use App\Domain\Users\Configuration\PasswordHashingConfiguration;
use App\Domain\Users\Exception\UserCreationException;
use App\Domain\Users\Repository\UserRepositoryInterface;
use App\Domain\Users\WriteModel\User;

class CreateUserHandler
{
    private UserRepositoryInterface      $repository;
    private WriteModelPersister          $persister;
    private PasswordHashingConfiguration $hashingConfiguration;

    public function __construct(UserRepositoryInterface $repository, WriteModelPersister $persister,
                                PasswordHashingConfiguration $hashingConfiguration)
    {
        $this->repository = $repository;
        $this->persister  = $persister;
        $this->hashingConfiguration = $hashingConfiguration;
    }

    /**
     * @param CreateUserCommand $command
     *
     * @throws UserCreationException
     * @throws ValidationException
     */
    public function __invoke(CreateUserCommand $command)
    {
        $user = User::fromArray($command->toArray(), $this->hashingConfiguration);

        if ($this->repository->findUserByEmailAddress($user->getEmail()->getValue())) {
            throw UserCreationException::causeUserAlreadyExists();
        }

        $this->persister->persist($user);
        $this->persister->flush();
    }
}
