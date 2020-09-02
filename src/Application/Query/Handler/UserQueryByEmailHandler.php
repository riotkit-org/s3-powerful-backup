<?php declare(strict_types=1);

namespace App\Application\Query\Handler;

use App\Application\Query\UserQueryByEmail;
use App\Domain\Users\Repository\UserRepositoryInterface;
use App\Domain\Users\View\UserView;

class UserQueryByEmailHandler
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserQueryByEmail $query)
    {
        $rwModel = $this->repository->findUserByEmailAddress($query->email);
        return new UserView($rwModel->getEmail());
    }
}
