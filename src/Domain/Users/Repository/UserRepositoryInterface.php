<?php declare(strict_types=1);

namespace App\Domain\Users\Repository;

use App\Domain\Users\WriteModel\User;

interface UserRepositoryInterface
{
    public function findUserByEmailAddress(string $email): ?User;
}
