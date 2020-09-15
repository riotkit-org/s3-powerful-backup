<?php declare(strict_types=1);

namespace App\Domain\Backup\ValueObject;

use App\Domain\Common\ValueObject\ITSize;

class MaxOneVersionSize extends ITSize
{
    protected static string $field = 'maxOneVersionSize';
}
