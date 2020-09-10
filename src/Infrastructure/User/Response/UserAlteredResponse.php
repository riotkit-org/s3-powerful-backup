<?php declare(strict_types=1);

namespace App\Infrastructure\User\Response;

use App\Domain\Common\View\ViewModelInterface;
use App\Infrastructure\Common\Response\ObjectModifiedResponse;

class UserAlteredResponse extends ObjectModifiedResponse
{
    public static function asResultFromCreation(ViewModelInterface $view): ObjectModifiedResponse
    {
        return static::createFromView($view, static::STATUS_MODIFIED, static::HTTP_CREATED);
    }

    public static function asResultFromEdit(ViewModelInterface $view): ObjectModifiedResponse
    {
        return static::createFromView($view, static::STATUS_MODIFIED, static::HTTP_ACCEPTED);
    }
}
