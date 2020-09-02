<?php declare(strict_types=1);

namespace App\Infrastructure\User\Response;

use App\Infrastructure\Common\Response\CreationErrorResponse;

class UserCreatedResponse extends CreationErrorResponse
{
    public static function getResponseType(): string
    {
        return 'user.creation.ok';
    }
}
