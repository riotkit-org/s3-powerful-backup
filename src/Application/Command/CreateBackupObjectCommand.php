<?php declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Backup\WriteModel\Author;

/**
 * Creates a backup
 */
class CreateBackupObjectCommand
{
    public string $name;

    public string $description = '';

    public array $allowedFileTypes = [];

    public int $maxVersions;

    /**
     * @var string Size + unit eg. "5 GB"
     */
    public string $maxOneVersionSize;

    /**
     * @var string Same there, size + unit
     */
    public string $maxAllVersionsSize;

    public Author $currentUser;

    public function toArray(): array
    {
        return [
            'name'                  => $this->name,
            'description'           => $this->description,
            'allowed_file_types'    => $this->allowedFileTypes,
            'max_versions'          => $this->maxVersions,
            'max_one_version_size'  => $this->maxOneVersionSize,
            'max_all_versions_size' => $this->maxAllVersionsSize
        ];
    }
}
