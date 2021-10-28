<?php

namespace App\Command\Booking\BookTicket;

use Happyr\Validator\Constraint\EntityExist;
use Symfony\Component\Validator\Constraints as Assert;

class BookTicketCommand
{
    /**
     * @Assert\NotBlank
     * @EntityExist(
     * entity="App\Domain\Booking\Entity\Session\Session",
     * message="Не удалось найти сессию для бронирования билета"
     * )
     */
    public $sessionId;

    /**
     * @Assert\NotBlank
     **/
    public $name;

    /**
     * @Assert\NotBlank
     **/
    public $phone;

    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }
}
