<?php declare(strict_types=1);

namespace App\Domain\Storage\Factory;

use App\Domain\Security\Configuration\StorageManagementConfiguration;
use Psr\Log\LoggerInterface;
use Twig\Environment as Twig;


class PolicyFactory
{
    private LoggerInterface $logger;
    private Twig            $templating;

    private string $policiesDirectory;
    private string $projectDir;

    public function __construct(StorageManagementConfiguration $configuration, Twig $templating,
                                LoggerInterface $logger, string $projectDir)
    {
        $this->logger            = $logger;
        $this->projectDir        = $projectDir;
        $this->templating        = $templating;
        $this->policiesDirectory = $configuration->getPoliciesDirectory();
    }

    public function createPolicyFromTemplate(string $policyName, array $vars): string
    {
        $policyPath = str_replace(
            '%kernel.project_dir%',
            $this->projectDir,
            $this->policiesDirectory . '/' . $policyName
        );

        if (!is_file($policyPath)) {
            // @todo: Rewrite into proper exception
            throw new \Exception('Policy at path "' . $policyPath . '" does not exist');
        }

        $policyContent = $this->templating->render('@policies/' . $policyName, $vars);
        $this->logger->debug('Rendering policy: ' . $policyContent);

        return $policyContent;
    }
}
