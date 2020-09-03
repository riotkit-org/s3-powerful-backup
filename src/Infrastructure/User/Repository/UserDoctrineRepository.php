<?php declare(strict_types=1);

namespace App\Infrastructure\User\Repository;

use App\Domain\Users\Repository\UserRepositoryInterface;
use App\Domain\Users\WriteModel\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @see \App\Application\Command\CreateUserCommand
 */
class UserDoctrineRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findUserByEmailAddress(string $email): ?User
    {
        $qb = $this->createQueryBuilder('user');
        $qb->where('user.email = :email');
        $qb->setParameter('email', $email);

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }
}
