<?php declare(strict_types=1);

namespace App\Infrastructure\Backup\Controller;

use App\Application\Command\CreateBackupObjectCommand;
use App\Infrastructure\Common\DependencyInjection\ApplicationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageBackupDefinitionController
{
    /**
     * @Route("/backup/object", methods={"POST"})
     *
     * @param Request $request
     * @param ApplicationContext $ctx
     * @return Response
     */
    public function createAction(Request $request, ApplicationContext $ctx): Response
    {
        $command = $ctx->handleCommand($request, CreateBackupObjectCommand::class);
    }
}
