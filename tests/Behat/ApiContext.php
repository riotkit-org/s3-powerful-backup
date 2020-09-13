<?php declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 */
final class ApiContext implements Context
{
    private KernelInterface $kernel;
    private ?Response $response;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When I create admin :user identified with :password from :organization organization
     *
     * @param string $user
     * @param string $password
     * @param string $organization
     *
     * @throws \Exception
     */
    public function createAdminUser(string $user, string $password, string $organization): void
    {
        $this->response = $this->kernel->handle(
            Request::create('/api/v1/user', 'POST', [], [], [], [], json_encode([
                'email'        => $user,
                'password'     => $password,
                'organization' => $organization,
                'about'        => 'Created in API tests',
                'roles'        => ['ROLE_ADMIN']
            ]))
        );
    }

    /**
     * @Then I should see confirmation about created user account
     */
    public function shouldSeeUserCreatedSuccessfullyConfirmation(): void
    {
        throw new \Exception('Not implemented yet');
    }
}
