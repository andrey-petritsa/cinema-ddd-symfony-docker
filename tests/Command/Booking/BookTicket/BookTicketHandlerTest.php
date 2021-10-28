<?php

namespace App\Tests\Command\Booking\BookTicket;

use App\Command\Booking\BookTicket\BookTicketCommand;
use App\Domain\Booking\Entity\Session\Session;
use App\Tests\CommandWebTestCase;

class BookTicketHandlerTest extends CommandWebTestCase
{
    /** @test */
    public function afterHandleSessionSeatsDecrease()
    {
        $oneSeatSession = $this->getSessionWithOneSeat();
        $command = $this->getBookTicketCommand($oneSeatSession->getId());

        $this->getMessageBus()->dispatch($command);

        $this->assertEquals(0, $oneSeatSession->getNumberOfFreeSeats());
    }

    /** @test */
    public function afterHandleFullSessionGetException()
    {
        $this->expectExceptionMessage('Невозможно добавить билет. Сеанс заполнен');

        $existedSession = $this->getSessionWithOneSeat();
        $command = $this->getBookTicketCommand($existedSession->getId());

        $this->getMessageBus()->dispatch($command);
        $this->getMessageBus()->dispatch($command);
    }

    private function getSessionWithOneSeat(): Session
    {
        return $this->getRepository(Session::class)->findOneBy(['numberOfSeats' => 1]);
    }

    private function getBookTicketCommand($sessionId)
    {
        $bookTicketCommand = new BookTicketCommand($sessionId);
        $bookTicketCommand->name = 'Андрей';
        $bookTicketCommand->phone = '73573';

        return $bookTicketCommand;
    }
}
