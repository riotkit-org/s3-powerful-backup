<?php declare(strict_types=1);

namespace App\Domain\Common\View;

interface IdAwareViewInterface
{
    public function getId(): ?string;
}
