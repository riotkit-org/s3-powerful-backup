<?php declare(strict_types=1);

namespace App\Domain\Storage\Aggregate;

use App\Domain\Storage\WriteModel\Bucket;

class ObjectSpaceAggregate
{
    /**
     * @var Bucket Read-only bucket, where backup is only read
     */
    private Bucket $readBucket;

    /**
     * @var Bucket Write-only bucket where backup is staged
     */
    private Bucket $stageBucket;

    public function __construct(Bucket $readBucket, Bucket $stageBucket)
    {

    }
}
