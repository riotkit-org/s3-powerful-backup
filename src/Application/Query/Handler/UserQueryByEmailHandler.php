<?php declare(strict_types=1);

namespace App\Application\Query\Handler;

use App\Application\Query\UserByEmailQuery;
use App\Domain\Users\Repository\UserRepositoryInterface;
use App\Domain\Users\View\UserView;

class UserQueryByEmailHandler
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserByEmailQuery $query)
    {
        $view = $this->repository->findUserByEmailAddress($query->email);

        if (!$view) {
            $query->setResult(null);
            return;
        }

        $query->setResult($view);
    }
}
