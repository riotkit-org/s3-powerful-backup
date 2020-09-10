<?php declare(strict_types=1);

namespace App\Domain\Users\View;

use App\Domain\Common\View\IdAwareViewInterface;
use App\Domain\Common\View\ViewModelInterface;
use App\Domain\Users\Configuration\PasswordHashingConfiguration;
use App\Domain\Users\ValueObject\Password;
use Symfony\Component\Security\Core\User\UserInterface;

class UserView implements \JsonSerializable, UserInterface, ViewModelInterface, IdAwareViewInterface
{
    public string $id;
    public string $email;
    public string $password;
    public string $organization;
    public string $about;
    public array  $roles;
    public string $salt;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function jsonSerialize()
    {
        return [
            'id'           => $this->id,
            'email'        => $this->email,
            'roles'        => $this->roles,
            'organization' => $this->organization,
            'about'        => $this->about
        ];
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        $this->password = '';
    }

    public function isPasswordMatching(string $compareTo, PasswordHashingConfiguration $hashingConfiguration)
    {
        return $this->password === Password::fromString($compareTo, $this->salt, $hashingConfiguration)->getValue();
    }

    public function isEmailEqualTo(string $value)
    {
        return $this->email === $value;
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}
