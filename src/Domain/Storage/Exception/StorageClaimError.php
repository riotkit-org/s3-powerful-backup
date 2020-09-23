<?php declare(strict_types=1);

namespace App\Domain\Storage\Exception;

use App\Domain\Common\Exception\DomainAssertionFailure;
use App\Domain\Common\Exception\DomainConstraintViolatedException;
use App\Domain\Security\Errors;
use App\Domain\Storage\ValueObject\MaxAllVersionsSize;

class StorageClaimError extends DomainAssertionFailure
{
    public static function causeDeclaredSpaceExceedsCurrentFreeSpace()
    {
        return static::fromErrors([
            DomainConstraintViolatedException::fromString(
                MaxAllVersionsSize::$field,
                Errors::ERR_MSG_STORAGE_NO_DISK_SPACE,
                Errors::ERR_STORAGE_NO_DISK_SPACE
            )
        ]);
    }
}
