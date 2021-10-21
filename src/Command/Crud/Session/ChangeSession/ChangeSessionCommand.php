<?php

namespace App\Command\Crud\Session\ChangeSession;

use Happyr\Validator\Constraint\EntityExist;
use Symfony\Component\Validator\Constraints as Assert;

class ChangeSessionCommand
{
    /**
     * @Assert\NotBlank
     * @EntityExist(entity="App\Domain\Booking\Entity\Session\Session")
     */
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
     * @Assert\Date
     **/
    public $startAt;

    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }
}
