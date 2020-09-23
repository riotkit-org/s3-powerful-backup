<?php declare(strict_types=1);

namespace App\Application\Query\Handler;

use App\Application\Query\TotalDeclaredDiskSpaceQuery;
use App\Domain\Backup\Repository\BackupObjectRepositoryInterface;

class TotalDeclaredDiskSpaceHandler
{
    private BackupObjectRepositoryInterface $repository;

    public function __construct(BackupObjectRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(TotalDeclaredDiskSpaceQuery $query)
    {
        $query->setResult($this->repository->findSumOfTotalDeclaredSpaceByBackups());
    }
}
