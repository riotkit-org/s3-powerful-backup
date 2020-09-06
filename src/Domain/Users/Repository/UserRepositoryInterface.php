<?php declare(strict_types=1);

namespace App\Domain\Users\Repository;

use App\Domain\Users\View\UserView;

interface UserRepositoryInterface
{
    public function findUserByEmailAddress(string $email): ?UserView;
    public function findUserByCredentials(string $email, string $password): ?UserView;
}
