<?php declare(strict_types=1);

namespace App\Domain\Users\ValueObject;

use App\Domain\Common\Exception\DomainConstraintViolatedException;
use App\Domain\Security\Errors;

class Email
{
    private string $value;

    /**
     * @param string $email
     * @return Email
     *
     * @throws DomainConstraintViolatedException
     */
    public static function fromString(string $email): Email
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw DomainConstraintViolatedException::fromString(
                'email',
                Errors::ERR_MSG_USER_MAIL_FORMAT_INVALID,
                Errors::ERR_USER_MAIL_FORMAT_INVALID
            );
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
