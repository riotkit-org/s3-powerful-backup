<?php declare(strict_types=1);

namespace App\Domain\Users\ValueObject;

use App\Domain\Common\Exception\ValidationConstraintViolatedException;

class Email
{
    private string $value;

    /**
     * @param string $email
     * @return Email
     *
     * @throws ValidationConstraintViolatedException
     */
    public static function fromString(string $email): Email
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw ValidationConstraintViolatedException::fromString('email', 'Invalid format');
        }

        $new = new static();
        $new->value = $email;

        return $new;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
