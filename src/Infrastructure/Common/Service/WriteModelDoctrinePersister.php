<?php declare(strict_types=1);

namespace App\Infrastructure\Common\Service;

use App\Domain\Common\Service\WriteModelPersister;
use App\Domain\Common\WriteModel\WriteModelInterface;
use Doctrine\ORM\EntityManagerInterface;

class WriteModelDoctrinePersister implements WriteModelPersister
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function persist(WriteModelInterface $object): void
    {
        $this->em->persist($object);
    }

    public function flush(): void
    {
        $this->em->flush();
    }
}
