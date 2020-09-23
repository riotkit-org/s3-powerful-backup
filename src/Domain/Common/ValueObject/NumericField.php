<?php declare(strict_types=1);

namespace App\Domain\Common\ValueObject;

use App\Domain\Common\Exception\DomainConstraintViolatedException;
use App\Domain\Security\Errors;

@define('BC_COMP_LESS', -1);
@define('BC_COMP_EQ', 0);
@define('BC_COMP_MORE', 1);

class NumericField
{
    protected static string $field;
    protected static int $min         = 0;
    protected static int $max         = 9999;
    protected static bool $allowFloat = false;
    protected static int  $scale      = 6;

    /**
     * Keeps the value in a string format (for precision)
     * Float separator: .
     *
     * @var string $value
     */
    protected string $value;

    /**
     * @param string|int $inputData
     *
     * @throws DomainConstraintViolatedException
     */
    public static function from($inputData)
    {
        if (!is_numeric($inputData)) {
            throw DomainConstraintViolatedException::fromString(
                static::$field,
                Errors::ERR_MSG_INPUT_NOT_NUMERIC,
                Errors::ERR_INPUT_NOT_NUMERIC
            );
        }

        if (bccomp((string) $inputData, (string) static::$min) === BC_COMP_LESS) {
            throw DomainConstraintViolatedException::fromString(
                static::$field,
                Errors::ERR_MSG_INPUT_NUMBER_TOO_LOW,
                Errors::ERR_INPUT_NUMBER_TOO_LOW
            );
        }

        if (bccomp((string) $inputData, (string) static::$max) === BC_COMP_MORE) {
            throw DomainConstraintViolatedException::fromString(
                static::$field,
                Errors::ERR_MSG_INPUT_NUMBER_TOO_HIGH,
                Errors::ERR_INPUT_NUMBER_TOO_HIGH
            );
        }

        $new = new static();
        $new->value = (string) $inputData;

        return $new;
    }

    public function isLowerThan(NumericField $second): bool
    {
        return bccomp($this->value, $second->value) === BC_COMP_LESS;
    }

    /**
     * @param NumericField $second
     *
     * @return static
     */
    public function multiply(NumericField $second)
    {
        $new = new static();
        $new->value = bcmul($this->value, $second->value);

        return $new;
    }

    /**
     * @param NumericField $field
     *
     * @return static
     */
    public function add(NumericField $field)
    {
        $new = new static();
        $new->value = bcadd($this->value, $field->value);

        return $new;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
