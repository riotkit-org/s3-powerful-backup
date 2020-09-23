<?php declare(strict_types=1);

namespace App\Domain\Backup\WriteModel;

use App\Domain\Common\WriteModel\WriteModelInterface;

class Author implements WriteModelInterface
{
    private string $id;
    private string $email;

    public function getId(): ?string
    {
        return $this->id;
    }
}
