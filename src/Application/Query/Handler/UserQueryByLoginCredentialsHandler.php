<?php declare(strict_types=1);

namespace App\Application\Query\Handler;

use App\Application\Query\UserByLoginCredentialsQuery;
use App\Domain\Users\Repository\UserRepositoryInterface;
use App\Domain\Users\View\UserView;

class UserQueryByLoginCredentialsHandler
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserByLoginCredentialsQuery $command): ?UserView
    {
        return $this->repository->findUserByCredentials($command->email, $command->password);
    }
}
