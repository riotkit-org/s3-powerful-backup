<?php declare(strict_types=1);

namespace App\Domain\Common\ValueObject\Storage;

use App\Domain\Common\ValueObject\NumericField;

class MaxVersions extends NumericField
{
    protected static string $field           = 'max_versions';
    protected static int    $min             = 1;
    protected static int    $max             = 99999;
}
