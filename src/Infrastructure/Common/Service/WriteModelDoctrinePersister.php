<?php declare(strict_types=1);

namespace App\Infrastructure\Common\Service;

use App\Domain\Common\Service\WriteModelPersister;
use App\Domain\Common\View\IdAwareViewInterface;
use App\Domain\Common\WriteModel\WriteModelInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class WriteModelDoctrinePersister implements WriteModelPersister
{
    private EntityManagerInterface $em;
    private ManagerRegistry        $registry;

    public function __construct(EntityManagerInterface $em, ManagerRegistry $registry)
    {
        $this->em       = $em;
        $this->registry = $registry;
    }

    public function persist(WriteModelInterface $object): void
    {
        $this->em->persist($object);
    }

    public function flush(): void
    {
        $this->em->flush();
    }

    public function findOneBy(array $fields, string $from): ?WriteModelInterface
    {
        /**
         * @var object|WriteModelInterface $object
         */
        $object = $this->createRepositoryClass($from)->findOneBy($fields);

        return $object;
    }

    public function findWriteModel(IdAwareViewInterface $view, string $from): ?WriteModelInterface
    {
        /**
         * @var object|WriteModelInterface $object
         */
        $object = $this->createRepositoryClass($from)->find($view->getId());

        return $object;
    }

    protected function createRepositoryClass(string $entityClass): ServiceEntityRepository
    {
        return new class ($this->registry, $entityClass) extends ServiceEntityRepository {
            public function __construct(ManagerRegistry $registry, $entityClass)
            {
                parent::__construct($registry, $entityClass);
            }
        };
    }
}
