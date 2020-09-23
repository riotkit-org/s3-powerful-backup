<?php declare(strict_types=1);

namespace App\Domain\Common\ValueObject;

use App\Domain\Common\Exception\DomainConstraintViolatedException;
use App\Domain\Security\Errors;
use function ByteUnits\parse as parse_str_to_bytes;

/**
 * Information Technology size - bytes
 * ====================================
 *
 * Megabytes, gigabytes, terabytes etc. are converted to bytes.
 * All operations are made on bytes for simplicity.
 */
class ITSize extends NumericField
{
    protected static int $max = 1024 * 1024 * 1024 * 1024; // a petabyte

    /**
     * @param string $value
     *
     * @return static
     *
     * @throws DomainConstraintViolatedException
     */
    public static function fromHumanReadableFormat(string $value)
    {
        try {
            $inBytes = (int) parse_str_to_bytes($value)->numberOfBytes();

        } catch (\Exception $e) {
            throw DomainConstraintViolatedException::fromString(
                static::$field,
                str_replace('{{ msg }}', $e->getMessage(), Errors::ERR_MSG_IT_SIZE_INVALID_FORMAT),
                Errors::ERR_IT_SIZE_INVALID_FORMAT
            );
        }

        return static::from($inBytes);
    }

    /**
     * @param int|string $bytes
     *
     * @return static
     *
     * @throws DomainConstraintViolatedException
     */
    public static function fromBytes($bytes)
    {
        if ((int) $bytes < 0) {
            throw DomainConstraintViolatedException::fromString(
                static::$field,
                Errors::ERR_MSG_IT_SIZE_CANNOT_BE_NEGATIVE,
                Errors::ERR_IT_SIZE_CANNOT_BE_NEGATIVE
            );
        }

        return static::from($bytes);
    }
}
