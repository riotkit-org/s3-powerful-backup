<?php declare(strict_types=1);

namespace App\Domain\Common\ValueObject\Storage;

use App\Domain\Common\ValueObject\ITSize;

class MaxAllVersionsSize extends ITSize
{
    public static string $field = 'maxAllVersionsSize';
}
