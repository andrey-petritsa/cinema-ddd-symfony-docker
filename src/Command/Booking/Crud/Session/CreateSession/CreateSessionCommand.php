<?php

namespace App\Command\Booking\Crud\Session\CreateSession;

use Happyr\Validator\Constraint\EntityExist;
use Symfony\Component\Validator\Constraints as Assert;

class CreateSessionCommand
{
    /**
     * @Assert\NotBlank
     **/
    public $sessionId;

    /**
     * @Assert\NotBlank
     * @EntityExist(entity="App\Domain\Booking\Entity\Movie")
     */
    public $movieId;

    /**
     * @Assert\PositiveOrZero
     * @Assert\NotBlank
     **/
    public $numberOfSeats;

    /**
     * @Assert\DateTime
     **/
    public $startAt;

    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }
}