<?php declare(strict_types=1);

namespace App\Infrastructure\User\Controller;

use App\Application\Command\CreateUserCommand;
use App\Application\Query\UserQueryByEmail;
use App\Domain\Users\Exception\UserCreationException;
use App\Infrastructure\Common\DependencyInjection\ServiceContext;
use App\Infrastructure\User\Response\UserCreatedResponse;
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
     * @param Request        $request
     * @param ServiceContext $ctx
     *
     * @throws UserCreationException
     *
     * @return Response
     */
    public function createAction(Request $request, ServiceContext $ctx): Response
    {
        // @todo: Permissions checking
        // @todo: FOS Rest

        /**
         * @var CreateUserCommand $command
         */
        $command = $ctx->serializer->deserialize($request->getContent(), CreateUserCommand::class, 'json');

        // throws UserCreationException
        $ctx->commandBus->handle($command);

        return new UserCreatedResponse(
            $ctx->queryBus->handle(new UserQueryByEmail($command->email))
        );
    }
}
