<?php

namespace App\Command\Crud\Session\DeleteSession;

use Happyr\Validator\Constraint\EntityExist;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteSessionCommand
{
    /**
    * @Assert\NotBlank
    * @EntityExist(entity="App\Domain\Booking\Entity\Session\Session")
    */
    public $sessionId;

    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }
}
