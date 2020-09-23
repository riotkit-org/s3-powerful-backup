<?php declare(strict_types=1);

namespace App\Domain\Backup\WriteModel;

use App\Domain\Backup\Collection\AllowedMimeTypes;
use App\Domain\Backup\ValueObject\Description;
use App\Domain\Backup\ValueObject\MaxAllVersionsSize;
use App\Domain\Backup\ValueObject\MaxOneVersionSize;
use App\Domain\Backup\ValueObject\MaxVersions;
use App\Domain\Backup\ValueObject\Title;
use App\Domain\Common\Exception\DomainConstraintViolatedException;
use App\Domain\Common\Exception\DomainAssertionFailure;
use App\Domain\Common\WriteModel\WriteModelHelper;
use App\Domain\Common\WriteModel\WriteModelInterface;
use App\Domain\Security\Errors;

class BackupObject implements WriteModelInterface
{
    private ?string $id;

    private \DateTimeImmutable $created;

    private Title $name;

    private Description $description;

    /**
     * @var AllowedMimeTypes
     */
    private AllowedMimeTypes $allowedFileTypes;

    /**
     * @var MaxVersions Maximum count of rotatable versions
     */
    private MaxVersions $maxVersions;

    private MaxOneVersionSize $maxOneVersionSize;

    private MaxAllVersionsSize $maxAllVersionsSize;

    /**
     * @var bool Is the backup activated or deactivated?
     */
    private bool $active = true;

    //
    // Relations
    //
    private StorageLocation $location;

    /**
     * Author of the object
     *
     * @var Author
     */
    private Author $createdBy;

    /**
     * @param array           $input
     * @param Author          $createdBy
     *
     * @return BackupObject
     *
     * @throws DomainAssertionFailure
     */
    public static function fromArray(array $input, Author $createdBy): BackupObject
    {
        $definition = new static();

        // creating a new object
        $definition->id = null;

        WriteModelHelper::withValidationErrorAggregation([
            function () use ($definition, $input) { $definition->name               = Title::fromString($input['name']); },
            function () use ($definition, $input) { $definition->description        = Description::fromString($input['description']); },
            function () use ($definition, $input) { $definition->allowedFileTypes   = AllowedMimeTypes::fromArray($input['allowed_file_types']); },
            function () use ($definition, $input) { $definition->maxVersions        = MaxVersions::from($input['max_versions']); },
            function () use ($definition, $input) { $definition->maxOneVersionSize  = MaxOneVersionSize::fromHumanReadableFormat($input['max_one_version_size']); },
            function () use ($definition, $input) { $definition->maxAllVersionsSize = MaxAllVersionsSize::fromHumanReadableFormat($input['max_all_versions_size']); },
            function () use ($definition) { $definition->created                    = new \DateTimeImmutable('now'); },
            function () use ($definition, $createdBy) { $definition->createdBy      = $createdBy; },

            // Validation - Maximum objects collection size must be at least: (maxVersions * maxOneVersionSize)
            function () use ($definition) {
                $minSpaceRequired = $definition->maxVersions->multiply($definition->maxOneVersionSize);

                if ($definition->maxAllVersionsSize->isLowerThan($minSpaceRequired)) {
                    throw DomainConstraintViolatedException::fromString(
                        MaxAllVersionsSize::$field,
                        Errors::ERR_MSG_MAX_COLLECTION_SIZE_NOT_ENOUGH_ESTIMATED,
                        Errors::ERR_MAX_COLLECTION_SIZE_NOT_ENOUGH_ESTIMATED
                    );
                }
            }
        ]);

        return $definition;
    }

    public function setStorageLocation(StorageLocation $location): void
    {
        $this->location = $location;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAllowedFileTypes(): AllowedMimeTypes
    {
        return $this->allowedFileTypes;
    }

    public function getMaxVersions(): MaxVersions
    {
        return $this->maxVersions;
    }

    public function getMaxOneVersionSize(): MaxOneVersionSize
    {
        return $this->maxOneVersionSize;
    }

    public function getMaxAllVersionsSize(): MaxAllVersionsSize
    {
        return $this->maxAllVersionsSize;
    }
}
