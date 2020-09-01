<?php declare(strict_types=1);

namespace App\Infrastructure\User\Form;

use App\Application\CreateUserCommand;
use Linio\Component\Input\InputHandler;

/**
 * @see CreateUserCommand
 */
class UserCreationForm extends InputHandler
{
    public function define()
    {
        $this->add('email', 'string');
        $this->add('password', 'string');
        $this->add('organization', 'string');
        $this->add('about', 'string');
        $this->add('roles', 'array');
    }
}
