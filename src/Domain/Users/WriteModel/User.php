<?php declare(strict_types=1);

namespace App\Domain\Users\WriteModel;

use App\Domain\Common\Exception\ValidationConstraintViolatedException;
use App\Domain\Common\Exception\ValidationException;
use App\Domain\Common\WriteModel\WriteModelHelper;
use App\Domain\Common\WriteModel\WriteModelInterface;
use App\Domain\Users\Collection\RolesCollection;
use App\Domain\Users\Configuration\PasswordHashingConfiguration;
use App\Domain\Users\ValueObject\About;
use App\Domain\Users\ValueObject\Email;
use App\Domain\Users\ValueObject\Organization;
use App\Domain\Users\ValueObject\Password;

class User implements WriteModelInterface
{
    private string $id;
    private string $salt;
    private Email $email;
    private Password $password;
    private Organization $organization;
    private About $about;
    private RolesCollection $roles;

    public function __construct()
    {
        $this->salt = base64_encode(random_bytes(32));
    }

    /**
     * @param array                        $input
     * @param PasswordHashingConfiguration $hashingConfiguration
     *
     * @return User
     *
     * @throws ValidationException
     */
    public static function fromArray(array $input, PasswordHashingConfiguration $hashingConfiguration): User
    {
        $user = new static();

        WriteModelHelper::callModelSetters([
            function () use ($user, $input) { $user->email        = Email::fromString($input['email']); },
            function () use ($user, $input, $hashingConfiguration) {
                $user->password = Password::fromString($input['password'], $user->salt, $hashingConfiguration);
            },
            function () use ($user, $input) { $user->organization = Organization::fromString($input['organization']); },
            function () use ($user, $input) { $user->about        = About::fromString($input['about']); },
            function () use ($user, $input) { $user->roles        = RolesCollection::fromArray($input['roles']); },
        ]);

        return $user;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setRoles(RolesCollection $roles): void
    {
        $this->roles = $roles;
    }

    public function mergeRoles(RolesCollection $roles): void
    {
        $this->roles->mergeWith($roles);
    }
}
