<?php declare(strict_types=1);

namespace App\Infrastructure\Common\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class CreationErrorResponse extends JsonResponse
{
    /**
     * @param string   $error
     * @param string[] $fieldErrors
     *
     * @return static
     */
    public static function createResponse(string $error, array $fieldErrors = [])
    {
        return new static([
            'error'  => $error,
            'fields' => $fieldErrors,
            'type'   => static::getResponseType()
        ], 400);
    }

    public static function getResponseType(): string
    {
        return 'common.creation.error';
    }
}
