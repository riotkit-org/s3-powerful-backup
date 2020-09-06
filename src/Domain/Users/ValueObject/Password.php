<?php declare(strict_types=1);

namespace App\Domain\Users\ValueObject;

use App\Domain\Common\Exception\ValidationConstraintViolatedException;
use App\Domain\Security\Errors;
use App\Domain\Users\Configuration\PasswordHashingConfiguration;

class Password
{
    private string $value;

    /**
     * @param string                       $value
     * @param PasswordHashingConfiguration $configuration
     *
     * @return Password
     *
     * @throws ValidationConstraintViolatedException
     */
    public static function fromString(string $value, PasswordHashingConfiguration $configuration): Password
    {
        if (strlen($value) < 8) {
            throw ValidationConstraintViolatedException::fromString(
                'password',
                Errors::ERR_MSG_USER_PASSWORD_TOO_SHORT,
                Errors::ERR_USER_PASSWORD_TOO_SHORT
            );
        }

        if (strlen($value) > 1024) {
            throw ValidationConstraintViolatedException::fromString(
                'password',
                Errors::ERR_MSG_USER_PASSWORD_TOO_LONG,
                Errors::ERR_USER_PASSWORD_TOO_LONG
            );
        }

        if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $value)) {
            throw ValidationConstraintViolatedException::fromString(
                'password',
                Errors::ERR_MSG_ERR_USER_PASSWORD_TOO_SIMPLE,
                Errors::ERR_USER_PASSWORD_TOO_SIMPLE
            );
        }

        $new = new static();
        $new->value = hash_pbkdf2('sha256', $value, $configuration->salt, $configuration->iterations);

        return $new;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
