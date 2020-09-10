<?php declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\ManageUserRolesCommand;
use App\Domain\Common\Exception\ValidationConstraintViolatedException;
use App\Domain\Common\Exception\ValidationException;
use App\Domain\Common\Service\WriteModelPersister;
use App\Domain\Users\Collection\RolesCollection;
use App\Domain\Users\Exception\UserNotFoundException;
use App\Domain\Users\Repository\UserRepositoryInterface;
use App\Domain\Users\WriteModel\User;

/**
 * Appends or replaces user roles
 * ==============================
 */
class ManageUserRolesHandler
{
    private UserRepositoryInterface $repository;
    private WriteModelPersister     $persister;

    public function __construct(UserRepositoryInterface $repository, WriteModelPersister $persister)
    {
        $this->repository = $repository;
        $this->persister  = $persister;
    }

    public function __invoke(ManageUserRolesCommand $command)
    {
        $userView = $this->repository->findUserByEmailAddress($command->email);

        if (!$userView) {
            throw UserNotFoundException::causeUserDoesNotExist();
        }

        /**
         * @var User $user
         */
        $user = $this->persister->findWriteModel($userView, User::class);

        try {
            if ($command->appendOnly) {
                $user->mergeRoles(RolesCollection::fromArray($command->roles));

            } elseif (!$command->appendOnly) {
                $user->setRoles(RolesCollection::fromArray($command->roles));
            }

        } catch (ValidationConstraintViolatedException $exception) {
            throw ValidationException::fromErrors([$exception]);
        }

        $this->persister->persist($user);
        $this->persister->flush();
    }
}
