<?php declare(strict_types=1);

namespace App\Domain\Storage\Service;

use App\Application\Query\TotalDeclaredDiskSpaceQuery;
use App\Domain\Common\Service\QueryBusInterface;
use App\Domain\Storage\Aggregate\ObjectSpaceAggregate;
use App\Domain\Security\Configuration\StorageManagementConfiguration;
use App\Domain\Storage\ValueObject\CurrentlyDeclaredDiskSpace;
use App\Domain\Storage\ValueObject\MaxAllVersionsSize;
use App\Domain\Storage\ValueObject\MaxOneVersionSize;
use App\Domain\Storage\ValueObject\MaxVersions;
use App\Domain\Storage\ValueObject\StorageMaximumSizeLimit;
use App\Infrastructure\Storage\Service\AWSDriver; // @todo use interface there

/**
 * Facade that answers for questions related to storage
 * ====================================================
 */
class StorageManager
{
    private StorageManagementConfiguration $configuration;
    private AWSDriver                      $driver;
    private QueryBusInterface              $queryBus;
    private StorageAuthenticatorInterface  $authenticator;

    public function __construct(StorageManagementConfiguration $configuration, AWSDriver $driver,
                                QueryBusInterface $queryBus, StorageAuthenticatorInterface $authenticator)
    {
        $this->authenticator = $authenticator;
        $this->configuration = $configuration;
        $this->driver        = $driver;
        $this->queryBus      = $queryBus;
    }

    public function getCurrentlyTotalDeclaredDiskSpace(): CurrentlyDeclaredDiskSpace
    {
        return CurrentlyDeclaredDiskSpace::fromBytes(
            $this->queryBus->query(new TotalDeclaredDiskSpaceQuery())
        );
    }

    public function createSpace(string $bucketName, array $allowedFileTypes, MaxVersions $maxFiles,
                                MaxOneVersionSize $maxOneFileSize, MaxAllVersionsSize $maxBucketSize): ObjectSpaceAggregate
    {
        $roBucketName    = $bucketName;
        $stageBucketName = $bucketName . '-stage';

        $roBucket    = $this->driver->createBucket($roBucketName);
        $stageBucket = $this->driver->createBucket($stageBucketName);

        $this->driver->makeBucketReadOnly($roBucketName);
        $this->driver->makeBucketWriteOnly($stageBucketName, $allowedFileTypes, $maxFiles, $maxBucketSize, $maxOneFileSize);

        // create RO user -> assign permissions
        // create RW user -> assign permissions
        // create a policy to limit file size, file count and file types

//        $this->authenticator->createAccessKeys();

        // @todo: Transaction support - revert on error

        return new ObjectSpaceAggregate($roBucket, $stageBucket);
    }

    public function checkThereIsSpaceForObject(MaxAllVersionsSize $bucketSize, MaxOneVersionSize $oneVersionSize): bool
    {
        return $this->getCurrentlyTotalDeclaredDiskSpace()
            ->add($bucketSize)
            ->add($oneVersionSize) // we must count also a temporary file
            ->isLowerThan($this->getDiskSpaceLimit());
    }

    private function getDiskSpaceLimit(): StorageMaximumSizeLimit
    {
        return $this->configuration->getTotalDiskSpaceLimit();
    }
}
