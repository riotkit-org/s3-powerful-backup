<?php declare(strict_types=1);

namespace App\Domain\Common\Service;

use App\Domain\Common\View\IdAwareViewInterface;
use App\Domain\Common\WriteModel\WriteModelInterface;

interface WriteModelPersister
{
    public function persist(WriteModelInterface $object): void;
    public function flush(): void;
    public function findOneBy(array $fields, string $from): ?WriteModelInterface;
    public function findWriteModel(IdAwareViewInterface $id, string $from): ?WriteModelInterface;
}
