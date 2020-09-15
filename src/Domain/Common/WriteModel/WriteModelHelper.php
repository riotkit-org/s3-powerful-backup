<?php declare(strict_types=1);

namespace App\Domain\Common\WriteModel;

use App\Domain\Common\Exception\ValidationConstraintViolatedException;
use App\Domain\Common\Exception\ValidationException;

class WriteModelHelper
{
    /**
     * Calls model setters, while correctly handling detailed errors for each of them
     *
     * @param callable[] $setters
     *
     * @throws ValidationException
     */
    public static function callModelSetters(array $setters)
    {
        $errors = [];

        foreach ($setters as $setter) {
            try {
                $setter();
            } catch (ValidationConstraintViolatedException $exception) {
                $errors[] = $exception;
            }
        }

        if ($errors) {
            throw ValidationException::fromErrors($errors);
        }
    }
}