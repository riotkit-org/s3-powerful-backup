<?php declare(strict_types=1);

namespace App\Domain\Common\WriteModel;

use App\Domain\Common\Exception\DomainConstraintViolatedException;
use App\Domain\Common\Exception\DomainAssertionFailure;

class WriteModelHelper
{
    /**
     * Calls model setters, while correctly handling detailed errors for each of them
     *
     * @param callable[] $setters
     *
     * @throws DomainAssertionFailure
     */
    public static function withValidationErrorAggregation(array $setters)
    {
        $errors = [];

        foreach ($setters as $setter) {
            try {
                $setter();
            } catch (DomainConstraintViolatedException $exception) {
                $errors[] = $exception;

            } catch (\Error $exception) {

                // when one field depends on other field, but that other field raised exception already and was not initialized
                if (strpos($exception->getMessage(), 'must not be accessed before initialization') === false) {
                    throw $exception;
                }
            }
        }

        if ($errors) {
            throw DomainAssertionFailure::fromErrors($errors);
        }
    }
}