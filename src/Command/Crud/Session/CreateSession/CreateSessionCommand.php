<?php

namespace App\Command\Crud\Session\CreateSession;

use Happyr\Validator\Constraint\EntityExist;
use Symfony\Component\Validator\Constraints as Assert;

class CreateSessionCommand
{
    public $sessionId;

    /**
     * @Assert\NotBlank
     * @EntityExist(entity="App\Domain\Booking\Entity\Movie")
     */
    public $movieId;

    public $numberOfSeats;

    public $startAt;

    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }
}
