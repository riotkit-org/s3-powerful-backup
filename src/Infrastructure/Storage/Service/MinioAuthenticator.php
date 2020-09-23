<?php declare(strict_types=1);

namespace App\Infrastructure\Storage\Service;

use App\Domain\Storage\Service\StorageAuthenticatorInterface;

class MinioAuthenticator implements StorageAuthenticatorInterface
{
    public function createAccessKeys(string $policyName)
    {
        // TODO: Implement createAccessKeys() method.
    }
}
