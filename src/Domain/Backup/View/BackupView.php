<?php declare(strict_types=1);

namespace App\Domain\Backup\View;

class BackupView
{
    /**
     * @var string Backup object id
     */
    private string $objectId;

    /**
     * @var int Maximum size of the Backup Object
     */
    private int $maxAllVersionsSize;
}
