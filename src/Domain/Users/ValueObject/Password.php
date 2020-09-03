<?php declare(strict_types=1);

namespace App\Domain\Users\ValueObject;

use App\Domain\Common\Exception\ValidationConstraintViolatedException;

class Password
{
    private string $value;

    /**
     * @param string $value
     * @param string $salt
     * @param int    $iterations
     *
     * @return Password
     *
     * @throws ValidationConstraintViolatedException
     */
    public static function fromString(string $value, string $salt, int $iterations): Password
    {
        if (strlen($value) < 8) {
            throw ValidationConstraintViolatedException::fromString('password', 'Password is too short');
        }

        if (strlen($value) > 1024) {
            throw ValidationConstraintViolatedException::fromString('password', 'Password is too long');
        }

        if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $value)) {
            throw ValidationConstraintViolatedException::fromString('password', 'Password should contain at least one special character');
        }

        $new = new static();
        $new->value = hash_pbkdf2('sha256', $value, $salt, 90000);

        return $new;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
