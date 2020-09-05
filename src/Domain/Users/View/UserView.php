<?php declare(strict_types=1);

namespace App\Domain\Users\View;

class UserView implements \JsonSerializable
{
    public string $email;

    public function __construct(string $email)
    {
        return $email;
    }

    public function jsonSerialize()
    {
        return [
            'email' => $this->email
        ];
    }
}
