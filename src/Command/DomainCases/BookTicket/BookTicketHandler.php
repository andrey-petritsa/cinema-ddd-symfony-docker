<?php

namespace App\Command\DomainCases\BookTicket;

use App\Domain\Booking\Repository\SessionRepository;
use App\Domain\Booking\TransferObject\TicketInformation;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class BookTicketHandler implements MessageHandlerInterface
{
    public function __construct(private SessionRepository $sessionRepository)
    {
    }

    public function __invoke(BookTicketCommand $command)
    {
        $session = $this->sessionRepository->find($command->sessionId);

        $ticketInformation = new TicketInformation($command->name, $command->phone);
        $session->bookTicket($ticketInformation);

        $this->sessionRepository->save($session);
    }
}
