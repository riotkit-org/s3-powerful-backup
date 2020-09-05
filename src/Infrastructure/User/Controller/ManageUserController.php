<?php declare(strict_types=1);

namespace App\Infrastructure\User\Controller;

use App\Application\Command\CreateUserCommand;
use App\Application\Query\UserQueryByEmail;
use App\Domain\Users\Exception\UserCreationException;
use App\Infrastructure\Common\Service\QueryBus;
use App\Infrastructure\Common\Service\CommandBus;
use App\Infrastructure\User\Response\UserCreatedResponse;
use App\Infrastructure\User\Response\UserCreationErrorResponse;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageUserController
{
    /**
     * //@IsGranted("ROLE_USERS_CREATE")
     *
     * @Route("/user", name="user_create", methods={"POST", "PUT"})
     *
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param CommandBus $cBus
     * @param QueryBus   $qBus
     *
     * @throws UserCreationException
     *
     * @return Response
     */
    public function createAction(Request $request, SerializerInterface $serializer, CommandBus $cBus, QueryBus $qBus): Response
    {
        // @todo: /api/v1 prefix
        // @todo: Permissions checking
        // @todo: FOS Rest

        /**
         * @var CreateUserCommand $command
         */
        $command = $serializer->deserialize($request->getContent(), CreateUserCommand::class, 'json');
        $cBus->handle($command);


        return new UserCreatedResponse(
            $qBus->handle(new UserQueryByEmail($command->email))
        );
    }
}
