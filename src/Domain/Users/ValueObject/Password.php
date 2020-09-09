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
     * @param string                       $salt
     * @param PasswordHashingConfiguration $configuration
     *
     * @return Password
     *
     * @throws ValidationConstraintViolatedException
     */
    public static function fromString(string $value, string $salt, PasswordHashingConfiguration $configuration): Password
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

        if (trim($value) !== $value) {
            throw ValidationConstraintViolatedException::fromString(
                'password',
                Errors::ERR_MSG_USER_PASSWORD_WHITESPACES,
                Errors::ERR_USER_PASSWORD_WHITESPACES
            );
        }

        $new = new static();
        $salted = $salt ? $value . '{' . $salt . '}' : $value;

        $digest = hash($configuration->algorithm, $salted, true);

        for ($i = 1; $i < $configuration->iterations; ++$i) {
            $digest = hash($configuration->algorithm, $digest.$salted, true);
        }

        $new->value = bin2hex($digest);

        return $new;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
