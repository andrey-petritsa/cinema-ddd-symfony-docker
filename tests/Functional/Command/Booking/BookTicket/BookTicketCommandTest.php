<?php

namespace App\Tests\Functional\Command\Booking\BookTicket;

use App\Command\Booking\BookTicket\BookTicketCommand;
use App\DataFixtures\TestSessionFixtures;
use App\Domain\Booking\Entity\Session\Session;
use App\Tests\Functional\CommandWebTestCase;
use App\Tests\Functional\ObjectPropertyTrait;
use App\Tests\Functional\ViolationAssertTrait;
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
        $this->getDatabaseTool()->loadFixtures([TestSessionFixtures::class]);
        $command = new BookTicketCommand(Uuid::uuid4());
        $existedSession = $this->getOneEntity(Session::class);
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

        $expectedErrorMessage = 'Не удалось найти сессию для бронирования билета';
        $this->assertPropertyIsInvalid('sessionId', $expectedErrorMessage, $violations);
    }

    private function getGoodCommand()
    {
        $this->getDatabaseTool()->loadFixtures([TestSessionFixtures::class]);
        $command = new BookTicketCommand(Uuid::uuid4());
        $command->name = 'Андрей';
        $command->phone = '735735';
        $command->sessionId = $this->getOneEntity(Session::class);

        return $command;
    }
}
