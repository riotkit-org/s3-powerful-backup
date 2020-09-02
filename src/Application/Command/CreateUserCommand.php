<?php declare(strict_types=1);

namespace App\Application\Command;

class CreateUserCommand
{
    public string $email;
    public string $password;
    public string $organization;
    public string $about;
    public array  $roles;
}
