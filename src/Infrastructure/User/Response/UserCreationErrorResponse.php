<?php declare(strict_types=1);

namespace App\Infrastructure\User\Response;

// @todo Add base class to standardize responses
use App\Domain\Users\Exception\UserCreationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserCreationErrorResponse extends JsonResponse
{
    public static function createResponse(UserCreationException $exception): UserCreationErrorResponse
    {
        return new static([
            'error' => $exception->getMessage()
        ]);
    }
}
