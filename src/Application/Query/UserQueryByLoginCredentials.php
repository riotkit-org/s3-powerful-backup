<?php declare(strict_types=1);

namespace App\Application\Query;

class UserQueryByLoginCredentials
{
    public string $email;
    public string $password;

    public function __construct(string $email, string $notEncodedPassword)
    {
        $this->email    = $email;
        $this->password = $notEncodedPassword;
    }
}
