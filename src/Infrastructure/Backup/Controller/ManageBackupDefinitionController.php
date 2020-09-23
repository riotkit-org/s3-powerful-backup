<?php declare(strict_types=1);

namespace App\Infrastructure\Backup\Controller;

use App\Application\Command\CreateBackupObjectCommand;
use App\Infrastructure\Common\DependencyInjection\ApplicationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ManageBackupDefinitionController
{
    /**
     * @IsGranted("ROLE_ACTION_CREATE_BACKUP_OBJECTS")
     *
     * @Route("/backup/object", methods={"POST"})
     *
     * @param Request            $request
     * @param UserInterface      $user
     * @param ApplicationContext $ctx
     *
     * @return Response
     */
    public function createAction(Request $request, UserInterface $user, ApplicationContext $ctx): Response
    {
        $command = $ctx->handleCommand($request, CreateBackupObjectCommand::class,
            function (CreateBackupObjectCommand $cmd) use ($user) {
                $cmd->authorEmail = $user->getEmail();
            }
        );
    }
}
