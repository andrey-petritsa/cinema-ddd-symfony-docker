<?php

namespace App\Tests\Command\Booking\Crud\Movie\DeleteMovie;

use App\Command\Booking\Crud\Movie\DeleteMovie\DeleteMovieCommand;
use App\Domain\Booking\Entity\Movie;
use App\Tests\CommandWebTestCase;
use App\Tests\ViolationAssertTrait;
use Ramsey\Uuid\Uuid;

class DeleteMovieCommandTest extends CommandWebTestCase
{
    use ViolationAssertTrait;

    /** @test */
    public function commandWithoutMovieInvalid()
    {
        $notExistedId = Uuid::uuid4();
        $deleteMovieCommand = new DeleteMovieCommand($notExistedId);

        $violations = $this->getValidator()->validate($deleteMovieCommand);

        $this->assertPropertyIsInvalid('movieId', 'Фильм не найден', $violations);
    }

    /** @test */
    public function commandWithMovieValid()
    {
        $existedMovie = $this->getOneEntity(Movie::class);
        $deleteMovieCommand = new DeleteMovieCommand($existedMovie->getId());

        $violations = $this->getValidator()->validate($deleteMovieCommand);

        $this->assertPropertyIsValid('movieId', $violations);
    }

    /** @test */
    public function blankCommandInvalid()
    {
        $deleteMovieCommand = new DeleteMovieCommand('');

        $violations = $this->getValidator()->validate($deleteMovieCommand);

        $this->assertPropertyIsInvalid('movieId', 'This value should not be blank.', $violations);
    }
}
