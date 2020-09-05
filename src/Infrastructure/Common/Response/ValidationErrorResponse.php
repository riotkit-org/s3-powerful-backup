<?php declare(strict_types=1);

namespace App\Infrastructure\Common\Response;

use App\Domain\Common\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class ValidationErrorResponse extends JsonResponse
{
    public static function createFromException(ValidationException $exc): ValidationErrorResponse
    {
        return new static([
            'error'  => 'JSON payload validation error',
            'fields' => static::aggregateFieldsIntoHash($exc->getConstraintsViolated()),
            'type'   => static::getResponseType()
        ], 400);
    }

    public static function getResponseType(): string
    {
        return 'validation.error';
    }

    private static function aggregateFieldsIntoHash(array $fields): array
    {
        $hash = [];

        foreach ($fields as $object) {
            /**
             * @var \JsonSerializable $object
             */
            $fields = $object->jsonSerialize();
            $name = $fields['field'];
            unset($fields['field']);

            $hash[$name] = $fields;
        }

        return $hash;
    }
}
