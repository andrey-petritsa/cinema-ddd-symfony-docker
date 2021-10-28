<?php

namespace App\Tests\Command\Booking\Crud\Session\ChangeSession;

use App\Command\Booking\Crud\Session\ChangeSession\ChangeSessionCommand;
use App\Domain\Booking\Entity\Movie;
use App\Domain\Booking\Entity\Session\Session;
use App\Tests\Command\Booking\Crud\Session\SessionTestTrait;
use App\Tests\CommandWebTestCase;
use App\Tests\ObjectPropertyTrait;
use App\Tests\ViolationAssertTrait;
use Ramsey\Uuid\Uuid;

class ChangeSessionCommandTest extends CommandWebTestCase
{
    use ViolationAssertTrait;
    use ObjectPropertyTrait;
    use SessionTestTrait;

    /** @test */
    public function blankCommandValid()
    {
        $command = new ChangeSessionCommand(Uuid::uuid4());
        $this->setBlankPropertiesTo($command);

        $violations = $this->getValidator()->validate($command);

        foreach ($this->getProperties($command) as $commandProperty) {
            $this->assertPropertyIsInvalid($commandProperty, 'This value should not be blank.', $violations);
        }
    }

    /** @test */
    public function commandWithExistedSessionValid()
    {
        $existedSession = $this->getRandomEntity(Session::class);
        $command = new ChangeSessionCommand($existedSession->getId());

        $violations = $this->getValidator()->validate($command);

        $this->assertPropertyIsValid('sessionId', $violations);
    }

    /** @test */
    public function commandWithoutExistedSessionInvalid()
    {
        $notExistedSessionID = Uuid::uuid4();
        $command = new ChangeSessionCommand($notExistedSessionID);

        $violations = $this->getValidator()->validate($command);

        $this->assertPropertyIsInvalid('sessionId', 'Не удалось найти сессию', $violations);
    }

    /** @test */
    public function commandWithPositiveSeatsValid()
    {
        $command = new ChangeSessionCommand(Uuid::uuid4());
        $positiveNumberOfSeats = 15;
        $command->numberOfSeats = $positiveNumberOfSeats;

        $violations = $this->getValidator()->validate($command);

        $this->assertPropertyIsValid('numberOfSeats', $violations);
    }

    /** @test */
    public function commandWithZeroSeatsValid()
    {
        $command = new ChangeSessionCommand(Uuid::uuid4());
        $zeroNumberOfSeats = 0;
        $command->numberOfSeats = $zeroNumberOfSeats;

        $violations = $this->getValidator()->validate($command);

        $this->assertPropertyIsValid('numberOfSeats', $violations);
    }

    /** @test */
    public function commandWithNegativeSeatsInvalid()
    {
        $command = new ChangeSessionCommand(Uuid::uuid4());
        $negativeNumberOfSeats = -15;
        $command->numberOfSeats = $negativeNumberOfSeats;

        $violations = $this->getValidator()->validate($command);

        $this->assertPropertyIsInvalid('numberOfSeats', 'This value should be either positive or zero.', $violations);
    }

    /** @test */
    public function commandWithCorrectDateValid()
    {
        $correctDateFormat = '2021-02-02 16:15:00';
        $command = new ChangeSessionCommand(Uuid::uuid4());
        $command->startAt = $correctDateFormat;

        $violations = $this->getValidator()->validate($command);

        $this->assertPropertyIsValid('startAt', $violations);
    }

    /** @test */
    public function commandWithExistedMovieValid()
    {
        $existedMovie = $this->getRandomEntity(Movie::class);
        $commandWithMovie = new ChangeSessionCommand(Uuid::uuid4());
        $commandWithMovie->movieId = $existedMovie->getId();

        $violations = $this->getValidator()->validate($commandWithMovie);

        $this->assertPropertyIsValid('movieId', $violations);
    }

    /** @test */
    public function commandWithoutExistedMovieInvalid()
    {
        $notExistedMovieId = Uuid::uuid4();
        $command = new ChangeSessionCommand(Uuid::uuid4());
        $command->movieId = $notExistedMovieId;

        $violations = $this->getValidator()->validate($command);

        $this->assertPropertyIsInvalid('movieId', 'Не удалось найти фильм', $violations);
    }

    /** @test */
    public function commandFromFabricSameAsSession()
    {
        $session = $this->getRandomEntity(Session::class);

        $changeSessionCommand = ChangeSessionCommand::createFromSession($session);

        $this->assertEqualsCommandWithSession($changeSessionCommand, $session);
    }
}
