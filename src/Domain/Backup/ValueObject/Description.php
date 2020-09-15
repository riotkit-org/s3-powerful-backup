<?php declare(strict_types=1);

namespace App\Domain\Backup\ValueObject;

use App\Domain\Common\ValueObject\TextField;

class Description extends TextField
{
    protected static string $field           = 'description';
    protected static int    $maxAllowedChars = 4096;
}
