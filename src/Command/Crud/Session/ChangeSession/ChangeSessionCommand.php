<?php

namespace App\Command\Crud\Session\ChangeSession;

use App\Domain\Booking\Entity\Session\Session;
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
     * @Assert\DateTime
     **/
    public $startAt;

    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public static function createFromSession(Session $session)
    {
        $changeSessionCommand = new ChangeSessionCommand($session->getId());
        $changeSessionCommand->movieId = $session->getMovieId();
        $changeSessionCommand->startAt = $session->getStartAt()->format('Y-m-d H:i:s');
        $changeSessionCommand->numberOfSeats = $session->getNumberOfSeats();

        return $changeSessionCommand;
    }
}
