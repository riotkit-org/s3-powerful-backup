<?php declare(strict_types=1);

namespace App\Domain\Backup\Repository;

interface BackupObjectRepositoryInterface
{
    public function findSumOfTotalDeclaredSpaceByBackups(): int;
}
