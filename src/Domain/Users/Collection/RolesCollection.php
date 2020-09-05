<?php declare(strict_types=1);

namespace App\Domain\Users\Collection;

use App\Domain\Common\Exception\ValidationConstraintViolatedException;
use App\Domain\Security\Roles;

class RolesCollection implements \JsonSerializable
{
    /**
     * @var string[]
     */
    protected array $roles = [];

    /**
     * @param array $roles
     * @param string $fieldName
     *
     * @return RolesCollection
     * @throws ValidationConstraintViolatedException
     */
    public static function fromArray(array $roles, string $fieldName = 'roles'): RolesCollection
    {
        $availableRoles = Roles::getRoleNames();

        foreach ($roles as $role) {
            if (!\in_array($role, $availableRoles, true)) {
                throw ValidationConstraintViolatedException::fromString($fieldName, 'Invalid role "' . $role . '"');
            }
        }

        $new = new static();
        $new->roles = $roles;

        return $new;
    }

    public function jsonSerialize()
    {
        return $this->roles;
    }
}
