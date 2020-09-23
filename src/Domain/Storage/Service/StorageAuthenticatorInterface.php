<?php declare(strict_types=1);

namespace App\Domain\Storage\Service;

interface StorageAuthenticatorInterface
{
    public function createAccessKeys(string $policyName);
}