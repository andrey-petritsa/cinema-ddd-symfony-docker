<?php

namespace App\Command\Session\ChangeSession;

use App\Domain\Booking\Entity\Session\Session;
use App\Repository\MovieRepository;
use App\Repository\SessionRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ChangeSessionHandler implements MessageHandlerInterface
{
    public function __construct(private SessionRepository $sessionRepository, private MovieRepository $movieRepository)
    {
    }

    public function __invoke(ChangeSessionCommand $command)
    {
        $session = $this->sessionRepository->find($command->sessionId);
        $movie = $this->movieRepository->find($command->movieId);

        $session->rewrite($movie, $command->numberOfSeats, new \DateTime($command->startAt));

        $this->sessionRepository->save($session);
    }
}
