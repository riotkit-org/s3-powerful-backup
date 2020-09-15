<?php declare(strict_types=1);

namespace App\Domain\Common\ValueObject;

use App\Domain\Common\Exception\ValidationConstraintViolatedException;
use App\Domain\Security\Errors;
use function ByteUnits\parse as parse_str_to_bytes;

class ITSize extends NumericField
{
    /**
     * @param string $value
     *
     * @return static
     *
     * @throws ValidationConstraintViolatedException
     */
    public static function fromHumanReadableFormat(string $value)
    {
        try {
            $inBytes = (int) parse_str_to_bytes($value)->numberOfBytes();

        } catch (\Exception $e) {
            throw ValidationConstraintViolatedException::fromString(
                static::$field,
                str_replace('{{ msg }}', $e->getMessage(), Errors::ERR_MSG_IT_SIZE_INVALID_FORMAT),
                Errors::ERR_IT_SIZE_INVALID_FORMAT
            );
        }

        return static::from($inBytes);
    }
}
