<?php

namespace App\Command\Session\CreateSession;

use App\Domain\Booking\Entity\Session\Session;
use App\Domain\Booking\TransferObject\SessionDto;
use Happyr\Validator\Constraint\EntityExist;
use Ramsey\Uuid\UuidInterface;
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

    public function __construct($sessionId, $movieId, $numberOfSeats, $startAt)
    {
        $this->sessionId = $sessionId;
        $this->movieId = $movieId;
        $this->numberOfSeats = $numberOfSeats;
        $this->startAt = $startAt;
    }
}
