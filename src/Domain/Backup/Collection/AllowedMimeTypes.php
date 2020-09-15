<?php declare(strict_types=1);

namespace App\Domain\Backup\Collection;

use App\Domain\Common\Collection\FileTypesCollection;

class AllowedMimeTypes extends FileTypesCollection
{
    protected static string $field = 'allowed_mime_types';
}
