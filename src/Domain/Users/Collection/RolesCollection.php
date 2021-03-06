<?php declare(strict_types=1);

namespace App\Domain\Users\Collection;

use App\Domain\Common\Exception\DomainConstraintViolatedException;
use App\Domain\Security\Errors;
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
     * @throws DomainConstraintViolatedException
     */
    public static function fromArray(array $roles, string $fieldName = 'roles'): RolesCollection
    {
        $availableRoles = Roles::getRoleNames();

        foreach ($roles as $role) {
            if (!\in_array($role, $availableRoles, true)) {
                throw DomainConstraintViolatedException::fromString(
                    $fieldName,
                    Errors::ERR_MSG_USER_ROLE_INVALID,
                    Errors::ERR_USER_ROLE_INVALID
                );
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

    public function mergeWith(RolesCollection $roles)
    {
        $this->roles = array_unique(array_merge($this->roles, $roles->roles));
    }
}
