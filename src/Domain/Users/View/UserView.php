<?php declare(strict_types=1);

namespace App\Domain\Users\View;

use App\Domain\Common\View\ViewModelInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserView implements \JsonSerializable, UserInterface, ViewModelInterface
{
    public string $id;
    public string $email;
    public string $password;
    public string $organization;
    public string $about;
    public array  $roles;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function jsonSerialize()
    {
        return [
            'email' => $this->email
        ];
    }

    public function getRoles()
    {
    }

    public function getPassword()
    {
    }

    public function getSalt()
    {
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
    }
}
