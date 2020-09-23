<?php declare(strict_types=1);

namespace App\Infrastructure\Storage\Repository;

use App\Domain\Backup\Repository\BackupObjectRepositoryInterface;
use App\Domain\Backup\WriteModel\BackupObject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BackupObjectDoctrineRepository extends ServiceEntityRepository implements BackupObjectRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BackupObject::class);
    }

    public function findSumOfTotalDeclaredSpaceByBackups(): int
    {
        $qb = $this->createQueryBuilder('bo');
        $qb->select('sum(bo.maxAllVersionsSize.value)');
        $qb->where('bo.active = true');

        return (int) $qb->getQuery()->getSingleResult();
    }
}
