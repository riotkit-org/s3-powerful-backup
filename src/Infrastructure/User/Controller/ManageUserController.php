<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Controller;

use App\Application\CreateUserCommand;
use App\Domain\Security\Roles;
use App\Domain\Users\Exception\UserCreationException;
use App\Infrastructure\User\Response\UserCreationErrorResponse;
use JMS\Serializer\SerializerInterface;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageUserController
{
    /**
     * @Route("/user", name="user_create", methods={"POST", "PUT"})
     *
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param CommandBus $bus
     *
     * @return Response
     */
    public function createAction(Request $request, SerializerInterface $serializer, CommandBus $bus): Response
    {
        /**
         * @var CreateUserCommand $command
         */
        $command = $serializer->deserialize($request->getContent(), CreateUserCommand::class, 'json');

        try {
            $bus->handle($command);

        } catch (UserCreationException $exception) {
            return new UserCreationErrorResponse($exception);
        }

        // @todo: QueryBus -> getUser()
        return new UserCreatedResponse();
    }
}
