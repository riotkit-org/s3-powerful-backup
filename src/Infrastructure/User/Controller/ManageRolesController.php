<?php declare(strict_types=1);

namespace App\Infrastructure\User\Controller;

use App\Application\Command\ManageUserRolesCommand;
use App\Application\Query\UserQueryByEmail;
use App\Infrastructure\Common\DependencyInjection\ApplicationContext;
use App\Infrastructure\User\Response\UserAlteredResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageRolesController
{
    /**
     * //@IsGranted("ACTION_USER_ASSIGN_ROLES")
     *
     * @Route("/user/{userEmail}/roles", name="user_roles_manage", methods={"PUT"})
     *
     * @param Request            $request
     * @param ApplicationContext $ctx
     * @param string             $userEmail
     *
     * @return Response
     */
    public function createAction(Request $request, ApplicationContext $ctx, string $userEmail): Response
    {
        /**
         * @var ManageUserRolesCommand $command
         */
        $command = $ctx->serializer->deserialize($request->getContent(), ManageUserRolesCommand::class, 'json');
        $command->email = $userEmail;
        $ctx->commandBus->handle($command);

        return UserAlteredResponse::asResultFromEdit($ctx->queryBus->handle(new UserQueryByEmail($command->email)));
    }
}
