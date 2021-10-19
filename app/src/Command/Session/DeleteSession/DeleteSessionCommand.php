<?php

namespace App\Command\Session\DeleteSession;

use Happyr\Validator\Constraint\EntityExist;
use Ramsey\Uuid\UuidInterface;
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
