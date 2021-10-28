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
     * @EntityExist(entity="App\Domain\Booking\Entity\Movie", message="Не найден фильм для сессии")
     */
    public $movieId;

    /**
     * @Assert\PositiveOrZero
     * @Assert\NotBlank
     **/
    public $numberOfSeats;

    /**
     * @Assert\DateTime
     * @Assert\NotBlank
     **/
    public $startAt;

    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }
}
