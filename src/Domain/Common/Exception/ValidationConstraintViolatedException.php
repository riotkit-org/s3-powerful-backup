<?php declare(strict_types=1);

namespace App\Domain\Common\Exception;

class ValidationConstraintViolatedException extends ApplicationException
{
    private string $field;

    public static function fromString(string $field, string $message, int $code = 400)
    {
        $new = new static();
        $new->message = $message;
        $new->code    = $code;
        $new->field   = $field;

        return $new;
    }
}
