<?php

namespace App\Command\Crud\Session\DeleteSession;

use App\Domain\Booking\Repository\SessionRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteSessionHandler implements MessageHandlerInterface
{
    public function __construct(private SessionRepository $sessionRepository)
    {
    }

    public function __invoke(DeleteSessionCommand $command)
    {
        $session = $this->sessionRepository->find($command->sessionId);
        $this->sessionRepository->delete($session);
    }
}
