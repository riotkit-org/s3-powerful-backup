<?php

declare(strict_types=1);

namespace App\Domain\Storage\WriteModel;

class Bucket
{
    /**
     * @var string S3 Bucket name
     */
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
