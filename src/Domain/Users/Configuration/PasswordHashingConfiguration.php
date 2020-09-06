<?php declare(strict_types=1);

namespace App\Domain\Users\Configuration;

class PasswordHashingConfiguration
{
    public string $salt;

    public int $iterations;

    public function __construct(string $salt, int $iterations)
    {
        $this->salt       = $salt;
        $this->iterations = $iterations;
    }
}
