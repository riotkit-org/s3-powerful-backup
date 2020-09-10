<?php declare(strict_types=1);

namespace App\Application\Command;

/**
 * Creates a new user
 */
class CreateUserCommand
{
    public string $email;
    public string $password;
    public string $organization = '';
    public string $about        = '';
    public array  $roles        = [];

    public function toArray(): array
    {
        return [
            'email'        => $this->email,
            'password'     => $this->password,
            'organization' => $this->organization,
            'about'        => $this->about,
            'roles'        => $this->roles
        ];
    }
}
