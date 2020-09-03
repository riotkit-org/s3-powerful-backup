<?php declare(strict_types=1);

namespace App\Domain\Common\Exception;

class ValidationException extends ApplicationException
{
    /**
     * @var ValidationConstraintViolatedException[]
     */
    private array $constraintsViolated = [];

    public static function fromErrors(array $violations): ValidationException
    {
        $new = new static('Data model validation failed');
        $new->constraintsViolated = $violations;

        return $new;
    }

    /**
     * @return ValidationConstraintViolatedException[]
     */
    public function getConstraintsViolated(): array
    {
        return $this->constraintsViolated;
    }
}
