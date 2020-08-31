<?php

declare(strict_types=1);

namespace App\Backup\Entity;

use App\Storage\Entity\Bucket;

class StorageLocation
{
    /**
     * @var Bucket Read-only bucket
     */
    private Bucket $targetBucket;

    /**
     * @var Bucket Write-only bucket
     */
    private Bucket $queueBucket;
}
