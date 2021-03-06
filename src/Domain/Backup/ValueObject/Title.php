<?php declare(strict_types=1);

namespace App\Domain\Backup\ValueObject;

use App\Domain\Common\ValueObject\TextField;

class Title extends TextField
{
    protected static string $field           = 'name';
    protected static int    $maxAllowedChars = 128;
}
