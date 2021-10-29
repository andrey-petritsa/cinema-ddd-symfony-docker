<?php

namespace App\Tests\Functional\Command\Booking\Crud\Movie\ChangeMovie;

use App\Command\Booking\Crud\Movie\ChangeMovie\ChangeMovieCommand;
use App\Command\Booking\Crud\Session\ChangeSession\ChangeSessionCommand;
use App\Domain\Booking\Entity\Movie;
use App\Tests\Functional\Command\Booking\Crud\Movie\MovieTestTrait;
use App\Tests\Functional\CommandWebTestCase;
use App\Tests\Functional\ObjectPropertyTrait;
use App\Tests\Functional\ViolationAssertTrait;
use Ramsey\Uuid\Nonstandard\Uuid;

class ChangeMovieCommandTest extends CommandWebTestCase
{
    use ViolationAssertTrait;
    use ObjectPropertyTrait;
    use MovieTestTrait;

    /** @test */
    public function commandWithoutMovieGetViolations()
    {
        $notExistedId = Uuid::uuid4();
        $changeMovieCommand = new ChangeMovieCommand($notExistedId);

        $violations = $this->getValidator()->validate($changeMovieCommand);

        $this->assertPropertyIsInvalid('movieId', 'Не найден фильм', $violations);
    }

    /** @test */
    public function commandWithMovieValid()
    {
        $changeMovieCommand = new ChangeMovieCommand(Uuid::uuid4());

        $changeMovieCommand->movieId = $this->getOneEntity(Movie::class)->getId();
        $violations = $this->getValidator()->validate($changeMovieCommand);

        $this->assertPropertyIsValid('movieId', $violations);
    }

    /** @test */
    public function blankCommandGetViolations()
    {
        $command = new ChangeSessionCommand(Uuid::uuid4());

        $this->setBlankPropertiesTo($command);
        $violations = $this->getValidator()->validate($command);

        foreach ($this->getProperties($command) as $commandProperty) {
            $this->assertPropertyIsInvalid($commandProperty, 'This value should not be blank.', $violations);
        }
    }

    /** @test */
    public function completeCommandValid()
    {
        $completeCommand = $this->makeCompleteCommand();

        $violations = $this->getValidator()->validate($completeCommand);

        foreach ($this->getProperties($completeCommand) as $commandProperty) {
            $this->assertPropertyIsValid($commandProperty, $violations);
        }
    }

    /** @test */
    public function commandFromFabricSameAsMovie()
    {
        $movie = new Movie(Uuid::uuid4(), 'Девчата', new \DateInterval('PT2H1M'));

        $changeMovieCommand = ChangeMovieCommand::createByMovie($movie);

        $this->assertEqualsCommandWithMovie($changeMovieCommand, $movie);
    }

    private function makeCompleteCommand()
    {
        $completeCommand = new ChangeMovieCommand(Uuid::uuid4());
        $completeCommand->movieId = $this->getOneEntity(Movie::class)->getId();
        $completeCommand->duration = 'PT2H1M';
        $completeCommand->name = 'Девчата';

        return $completeCommand;
    }
}
