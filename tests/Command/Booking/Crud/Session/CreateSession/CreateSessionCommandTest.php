<?php

namespace App\Tests\Command\Booking\Crud\Session\CreateSession;

use App\Command\Booking\Crud\Session\CreateSession\CreateSessionCommand;
use App\Tests\CommandWebTestCase;
use App\Tests\ObjectPropertyTrait;
use App\Tests\ViolationAssertTrait;
use Ramsey\Uuid\Uuid;

class CreateSessionCommandTest extends CommandWebTestCase
{
    use ViolationAssertTrait;
    use ObjectPropertyTrait;

    /** @test */
    public function blankCommandInvalid()
    {
        $command = new CreateSessionCommand(Uuid::uuid4());
        $this->setBlankPropertiesTo($command);

        $violations = $this->getValidator()->validate($command);

        foreach ($this->getProperties($command) as $property) {
            $this->assertPropertyIsInvalid($property, 'This value should not be blank.', $violations);
        }
    }

    /** @test */
    public function commandWithNotExistedMovieInvalid()
    {
        $createSessionCommand = new CreateSessionCommand(Uuid::uuid4());
        $nonExistedMovieId = Uuid::uuid4();
        $createSessionCommand->movieId = $nonExistedMovieId;

        $violations = $this->getValidator()->validate($createSessionCommand);

        $this->assertPropertyIsInvalid('movieId', 'Не найден фильм для сессии', $violations);
    }

    /** @test */
    public function commandWithNegativeSeatsIncorrect()
    {
        $negativeNumbersOfSeats = -15;
        $createSessionCommand = new CreateSessionCommand(Uuid::uuid4());
        $createSessionCommand->numberOfSeats = $negativeNumbersOfSeats;

        $violations = $this->getValidator()->validate($createSessionCommand);

        $this->assertPropertyIsInvalid(
            'numberOfSeats',
            'This value should be either positive or zero.',
            $violations
        );
    }

    /** @test */
    public function commandWithBadDateIncorrect()
    {
        $badDate = '25:02:-1996';
        $createSessionCommand = new CreateSessionCommand(Uuid::uuid4());
        $createSessionCommand->startAt = $badDate;

        $violations = $this->getValidator()->validate($createSessionCommand);

        $this->assertPropertyIsInvalid('startAt', 'This value is not a valid datetime.', $violations);
    }

    /** @test */
    public function commandWithGoodDateCorrect()
    {
        $createSessionCommand = new CreateSessionCommand(Uuid::uuid4());
        $createSessionCommand->startAt = '2021-02-02 16:15:00';

        $violations = $this->getValidator()->validate($createSessionCommand);

        $this->assertPropertyIsValid('startAt', $violations);
    }
}
