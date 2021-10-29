<?php

namespace App\Tests\Functional\Command\Booking\BookTicket;

use App\Command\Booking\BookTicket\BookTicketCommand;
use App\DataFixtures\SessionWithOneSeat;
use App\Domain\Booking\Entity\Session\Session;
use App\Tests\Functional\CommandWebTestCase;

class BookTicketHandlerTest extends CommandWebTestCase
{
    /** @test */
    public function afterHandleSessionSeatsDecrease()
    {
        $this->getDatabaseTool()->loadFixtures([SessionWithOneSeat::class]);
        $oneSeatSession = $this->getOneEntity(Session::class);
        $command = $this->getBookTicketCommand($oneSeatSession->getId());

        $this->getMessageBus()->dispatch($command);

        $this->assertEquals(0, $oneSeatSession->getNumberOfFreeSeats());
    }

    /** @test */
    public function afterHandleFullSessionGetException()
    {
        $this->getDatabaseTool()->loadFixtures([SessionWithOneSeat::class]);
        $this->expectExceptionMessage('Невозможно добавить билет. Сеанс заполнен');

        $zeroSeatsSession = $this->getOneEntity(Session::class);
        $command = $this->getBookTicketCommand($zeroSeatsSession->getId());

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
