<?php declare(strict_types=1);

namespace App\Application\Query;

class UserQueryByEmail extends BaseQuery
{
    public string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }
}
