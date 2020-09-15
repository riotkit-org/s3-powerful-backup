<?php declare(strict_types=1);

namespace App\Domain\Common\ValueObject;

use App\Domain\Common\Exception\ValidationConstraintViolatedException;
use App\Domain\Security\Errors;

@define('BC_COMP_LESS', -1);
@define('BC_COMP_EQ', 0);
@define('BC_COMP_MORE', 1);

abstract class NumericField
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
     * @throws ValidationConstraintViolatedException
     */
    public static function from($inputData)
    {
        if (!is_numeric($inputData)) {
            throw ValidationConstraintViolatedException::fromString(
                static::$field,
                Errors::ERR_MSG_INPUT_NOT_NUMERIC,
                Errors::ERR_INPUT_NOT_NUMERIC
            );
        }

        if (bccomp($inputData, static::$min) === BC_COMP_LESS) {
            throw ValidationConstraintViolatedException::fromString(
                static::$field,
                Errors::ERR_MSG_INPUT_NUMBER_TOO_LOW,
                Errors::ERR_INPUT_NUMBER_TOO_LOW
            );
        }

        if (bccomp($inputData, static::$max) === BC_COMP_MORE) {
            throw ValidationConstraintViolatedException::fromString(
                static::$field,
                Errors::ERR_MSG_INPUT_NUMBER_TOO_HIGH,
                Errors::ERR_INPUT_NUMBER_TOO_HIGH
            );
        }

        $new = new static();
        $new->value = $inputData;

        return $new;
    }
}
