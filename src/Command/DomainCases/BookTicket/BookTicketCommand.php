<?php

namespace App\Command\DomainCases\BookTicket;

use Happyr\Validator\Constraint\EntityExist;
use Symfony\Component\Validator\Constraints as Assert;

class BookTicketCommand
{
    /**
     * @Assert\NotBlank
     * @EntityExist(entity="App\Domain\Booking\Entity\Session\Session")
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
