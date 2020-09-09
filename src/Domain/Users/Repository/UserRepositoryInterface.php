<?php declare(strict_types=1);

namespace App\Domain\Users\Repository;

use App\Domain\Users\View\UserView;

interface UserRepositoryInterface
{
    public function findUserByEmailAddress(string $email): ?UserView;

    /**
     * Find a user by pair of e-mail and password (plaintext)
     *
     * @param string $email
     * @param string $password
     *
     * @return UserView|null
     */
    public function findUserByCredentials(string $email, string $password): ?UserView;
}
