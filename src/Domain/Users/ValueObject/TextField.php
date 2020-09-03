<?php declare(strict_types=1);

namespace App\Domain\Users\ValueObject;

use App\Domain\Common\Exception\ValidationConstraintViolatedException;

class TextField
{
    private string $value;

    /**
     * @param string $value
     *
     * @return TextField
     *
     * @throws ValidationConstraintViolatedException
     */
    public static function fromString(string $value): TextField
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
