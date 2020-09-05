<?php declare(strict_types=1);

namespace App\Domain\Common\Exception;

class ValidationException extends ApplicationException
{
    /**
     * @var ValidationConstraintViolatedException[]
     */
    protected array $constraintsViolated = [];

    /**
     * @param array $violations
     * @param string $message
     * @param int|null $code
     *
     * @return ValidationException|static
     */
    public static function fromErrors(array $violations, string $message = 'Data model validation failed', ?int $code = null): ValidationException
    {
        $new = new static($message, $code);
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
