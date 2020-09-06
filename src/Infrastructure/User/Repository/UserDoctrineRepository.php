<?php declare(strict_types=1);

namespace App\Infrastructure\User\Repository;

use App\Domain\Users\Configuration\PasswordHashingConfiguration;
use App\Domain\Users\Repository\UserRepositoryInterface;
use App\Domain\Users\ValueObject\Password;
use App\Domain\Users\View\UserView;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @see CreateUserCommand
 */
class UserDoctrineRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    private PasswordHashingConfiguration $hashingConfiguration;

    public function __construct(ManagerRegistry $registry, PasswordHashingConfiguration $hashingConfiguration)
    {
        $this->hashingConfiguration = $hashingConfiguration;

        parent::__construct($registry, UserView::class);
    }

    public function findUserByEmailAddress(string $email): ?UserView
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

    public function findUserByCredentials(string $email, string $password): ?UserView
    {
        $qb = $this->createQueryBuilder('user');
        $qb->where('user.email = :email AND user.password = :password');
        $qb->setParameters([
            'email'    => $email,
            'password' => Password::fromString($password, $this->hashingConfiguration)->getValue()
        ]);

        try {
            return $qb->getQuery()->getSingleResult();

        } catch (NoResultException $exception) {
            return null;
        }
    }
}
