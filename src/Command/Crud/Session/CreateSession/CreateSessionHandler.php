<?php

namespace App\Command\Crud\Session\CreateSession;

use App\Domain\Booking\Entity\Session\Session;
use App\Domain\Booking\Repository\MovieRepository;
use App\Domain\Booking\Repository\SessionRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateSessionHandler implements MessageHandlerInterface
{
    public function __construct(private SessionRepository $sessionRepository, private MovieRepository $movieRepository)
    {
    }

    public function __invoke(CreateSessionCommand $command)
    {
        $movie = $this->movieRepository->find($command->movieId);
        $session = new Session($command->sessionId, $movie, $command->numberOfSeats, new \DateTime($command->startAt));

        $this->sessionRepository->save($session);
    }
}
