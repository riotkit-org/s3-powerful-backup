<?php declare(strict_types=1);

namespace App\Infrastructure\Storage\Service;

use App\Domain\Security\Configuration\StorageManagementConfiguration;
use App\Domain\Storage\Factory\PolicyFactory;
use App\Domain\Storage\Policies;
use App\Domain\Storage\WriteModel\Bucket;
use Aws\S3\S3Client;

class AWSDriver
{
    private S3Client      $aws;
    private PolicyFactory $policyFactory;

    public function __construct(StorageManagementConfiguration $configuration, PolicyFactory $policyFactory)
    {
        $this->policyFactory = $policyFactory;
        $this->aws           = new S3Client([
            'version'                 => $configuration->getVersion(),
            'region'                  => $configuration->getRegion(),
            'endpoint'                => $configuration->getEndpoint(),
            'use_path_style_endpoint' => true,
            'credentials'             => [
                'key'    => $configuration->getKey(),
                'secret' => $configuration->getSecret()
            ]
        ]);
    }

    public function createBucket(string $name): Bucket
    {
        $this->aws->createBucket([
            'Bucket' => $name
        ]);

        return new Bucket($name);
    }

    public function makeBucketReadOnly(string $name)
    {
        $this->aws->putBucketPolicy([
            'Bucket' => $name,
            'Policy' => $this->policyFactory->createPolicyFromTemplate(
                Policies::POLICY_READ_ONLY,
                ['bucket_name' => $name]
            ),
        ]);
    }

    public function makeBucketWriteOnly(string $stageBucketName, array $allowedFileTypes, \App\Domain\Storage\ValueObject\MaxVersions $maxFiles, \App\Domain\Storage\ValueObject\MaxAllVersionsSize $maxBucketSize, \App\Domain\Storage\ValueObject\MaxOneVersionSize $maxOneFileSize)
    {

    }
}
