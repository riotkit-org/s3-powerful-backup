<?php

declare(strict_types=1);

namespace App\Users\Entity;

class User
{
    private string $email;

    private string $password;

    private string $organization = '';

    private string $about = '';

    private array $roles = [];
}
