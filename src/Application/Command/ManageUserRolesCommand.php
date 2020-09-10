<?php declare(strict_types=1);

namespace App\Application\Command;

/**
 * Adds or removes roles in existing user. The user is looked up by e-mail address
 */
class ManageUserRolesCommand
{
    public string $email;
    public bool   $appendOnly = false;
    public array  $roles;
}
