<?php declare(strict_types=1);

namespace App\Domain\Security\Configuration;

use App\Domain\Storage\ValueObject\StorageMaximumSizeLimit;

class StorageManagementConfiguration
{
    private string $endpoint;
    private string $version;
    private string $region;
    private string $key;
    private string $secret;
    private StorageMaximumSizeLimit $totalDiskSpaceLimit;
    private string $policiesDirectory;

    public function __construct(string $endpoint, string $version, string $region, string $key, string $secret,
                                string $totalDiskSpaceLimit, string $policiesDirectory)
    {
        $this->endpoint            = $endpoint;
        $this->version             = $version;
        $this->region              = $region;
        $this->key                 = $key;
        $this->secret              = $secret;
        $this->totalDiskSpaceLimit = StorageMaximumSizeLimit::fromHumanReadableFormat($totalDiskSpaceLimit);
        $this->policiesDirectory   = $policiesDirectory;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function getTotalDiskSpaceLimit(): StorageMaximumSizeLimit
    {
        return $this->totalDiskSpaceLimit;
    }

    public function getPoliciesDirectory(): string
    {
        return $this->policiesDirectory;
    }
}
