<?php declare(strict_types=1);

namespace App\Infrastructure\Frontend\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Displays a frontend application
 */
class FrontendController
{
    /**
     * @Route("/", name="frontend")
     *
     * @param UserInterface|null $user
     *
     * @return Response
     */
    public function displayDynamicFrontendApplication(Request $request, ?UserInterface $user): Response
    {
        return new Response('here will be vue/react/angular application');
    }
}
