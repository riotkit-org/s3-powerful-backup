<?php declare(strict_types=1);

namespace App\Domain\Common\ValueObject;

use App\Domain\Common\Exception\ValidationConstraintViolatedException;

class TextField
{
    protected string $value;

    /**
     * @param string $value
     *
     * @return static
     *
     * @throws ValidationConstraintViolatedException
     */
    public static function fromString(string $value)
    {
        // @todo: Validate string for non-utf8 characters

        $new = new static();
        $new->value = $value;

        return $new;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
