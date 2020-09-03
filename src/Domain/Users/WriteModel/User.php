<?php declare(strict_types=1);

namespace App\Domain\Users\WriteModel;

use App\Domain\Common\Exception\ValidationConstraintViolatedException;
use App\Domain\Common\Exception\ValidationException;
use App\Domain\Users\ValueObject\Email;
use App\Domain\Users\ValueObject\Password;

class User
{
    private string $id;

    private Email $email;

    private Password $password;

    private TextField $organization;

    private TextField $about;

    private RolesCollection $roles;

    /**
     * @param array  $input
     * @param string $passwordSalt
     * @param int    $passwordIterations
     *
     * @return User
     *
     * @throws ValidationException
     */
    public static function fromArray(array $input, string $passwordSalt, int $passwordIterations): User
    {
        $user = new static();
        $errors = [];

        $setters = [
            function () use ($user, $input) { $user->email        = Email::fromString($input['email']); },
            function () use ($user, $input, $passwordSalt, $passwordIterations) {
                $user->password = Password::fromString($input['password'], $passwordSalt, $passwordIterations);
            },
            function () use ($user, $input) { $user->organization = $input['organization']; },
            function () use ($user, $input) { $user->about        = $input['about']; },
            function () use ($user, $input) { $user->roles        = $input['roles']; },
        ];

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

        return $user;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
