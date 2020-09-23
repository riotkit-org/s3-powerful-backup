<?php declare(strict_types=1);

namespace App\Domain\Common\Exception;

class DomainConstraintViolatedException extends ApplicationException implements \JsonSerializable
{
    private string $field;

    public static function fromString(string $field, string $message, int $code)
    {
        $new = new static();
        $new->message = $message;
        $new->code    = $code;
        $new->field   = $field;

        return $new;
    }

    public function jsonSerialize()
    {
        return ['field' => $this->field, 'message' => $this->message, 'code' => $this->code];
    }
}
