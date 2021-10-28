<?php

namespace App\Tests\Command\Booking\BookTicket;

use App\Command\Booking\BookTicket\BookTicketCommand;
use App\Domain\Booking\Entity\Session\Session;
use App\Tests\CommandWebTestCase;
use App\Tests\ObjectPropertyTrait;
use App\Tests\ViolationAssertTrait;
use Ramsey\Uuid\Nonstandard\Uuid;

class BookTicketCommandTest extends CommandWebTestCase
{
    use ViolationAssertTrait;
    use ObjectPropertyTrait;

    /** @test */
    public function blankCommandInvalid()
    {
        $command = new BookTicketCommand(Uuid::uuid4());
        $this->setBlankPropertiesTo($command);

        $violations = $this->getValidator()->validate($command);

        foreach ($this->getProperties($command) as $property) {
            $this->assertPropertyIsInvalid($property, 'This value should not be blank.', $violations);
        }
    }

    /** @test */
    public function goodCommandIsValid()
    {
        $goodCommand = $this->getGoodCommand();

        $violations = $this->getValidator()->validate($goodCommand);

        foreach ($this->getProperties($goodCommand) as $property) {
            $this->assertPropertyIsValid($property, $violations);
        }
    }

    /** @test */
    public function commandWithExistedSessionValid()
    {
        $command = new BookTicketCommand(Uuid::uuid4());
        $existedSession = $this->getRandomEntity(Session::class);
        $command->sessionId = $existedSession;

        $violations = $this->getValidator()->validate($command);

        $this->assertPropertyIsValid('sessionId', $violations);
    }

    /** @test */
    public function commandWithNotExistedSessionInvalid()
    {
        $command = new BookTicketCommand(Uuid::uuid4());
        $nonExistedSessionId = Uuid::uuid4();
        $command->sessionId = $nonExistedSessionId;

        $violations = $this->getValidator()->validate($command);

        //QUESTION Наверное, было бы логично иметь единый конфиг заранее подготовленных сообщений о ошибках?
        // Было бы удобно проверять сообщение о ошибке через него,
        // и устанавливать его Constraint.message в команде
        $expectedErrorMessage = 'Не удалось найти сессию для бронирования билета';
        $this->assertPropertyIsInvalid('sessionId', $expectedErrorMessage, $violations);
    }

    private function getGoodCommand()
    {
        $command = new BookTicketCommand(Uuid::uuid4());
        $command->name = 'Андрей';
        $command->phone = '735735';
        $command->sessionId = $this->getRandomEntity(Session::class);

        return $command;
    }
}
