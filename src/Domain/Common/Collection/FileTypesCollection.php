<?php declare(strict_types=1);

namespace App\Domain\Common\Collection;

use App\Domain\Common\Exception\DomainConstraintViolatedException;
use App\Domain\Common\Provider\MimeTypeListProvider;
use App\Domain\Security\Errors;

abstract class FileTypesCollection
{
    /**
     * @var string[]
     */
    protected array $value = [];
    protected static string $field = '';

    /**
     * @param array $types
     *
     * @return static
     *
     * @throws DomainConstraintViolatedException
     */
    public static function fromArray(array $types)
    {
        $new = new static();
        $allowedList = MimeTypeListProvider::getMimeTypes();

        foreach ($types as $type) {
            if (!in_array($type, $allowedList, true)) {
                throw DomainConstraintViolatedException::fromString(
                    static::$field,
                    Errors::ERR_MSG_MIME_NOT_RECOGNIZED,
                    Errors::ERR_MIME_NOT_RECOGNIZED
                );
            }

            $new->value[] = $type;
        }

        return $new;
    }

    /**
     * @return string[]
     */
    public function getValue(): array
    {
        return $this->value;
    }
}
