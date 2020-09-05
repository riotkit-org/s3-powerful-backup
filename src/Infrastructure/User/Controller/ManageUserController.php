<?php declare(strict_types=1);

namespace App\Infrastructure\User\Controller;

use App\Application\Command\CreateUserCommand;
use App\Application\Query\UserQueryByEmail;
use App\Domain\Users\Exception\UserCreationException;
use App\Infrastructure\Common\DependencyInjection\ApplicationContext;
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
     * @Route("/user", name="user_create", methods={"POST"})
     *
     * @param Request        $request
     * @param ApplicationContext $ctx
     *
     * @return Response
     * @throws UserCreationException
     */
    public function createAction(Request $request, ApplicationContext $ctx): Response
    {
        // @todo: Permissions checking
        // @todo: FOS Rest

        /**
         * @throws UserCreationException
         * @var CreateUserCommand $command
         */
        $command = $ctx->handleCommand($request, CreateUserCommand::class);

        // @todo: EventBus -> UserWasCreatedEvent

        return new UserCreatedResponse(
            $ctx->queryBus->handle(new UserQueryByEmail($command->email))
        );
    }
}
