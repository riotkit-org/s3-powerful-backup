<?php declare(strict_types=1);

namespace App\Infrastructure\Common\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class ObjectCreatedResponse extends JsonResponse
{
    /**
     * @param $object
     *
     * @return static
     */
    public static function createResponse($object)
    {
        return new static([
            'object'   => $object,
            'type'     => static::getResponseType()
        ], 200);
    }

    public static function getResponseType(): string
    {
        return 'common.creation.ok';
    }
}
