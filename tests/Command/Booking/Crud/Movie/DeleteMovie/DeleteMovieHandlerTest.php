<?php

namespace App\Tests\Command\Booking\Crud\Movie\DeleteMovie;

use App\Command\Booking\Crud\Movie\DeleteMovie\DeleteMovieCommand;
use App\Domain\Booking\Entity\Movie;
use App\Tests\CommandWebTestCase;

class DeleteMovieHandlerTest extends CommandWebTestCase
{
    /** @test */
    public function movieNotExistAfterHandle()
    {
        $existedMovie = $this->getRandomEntity(Movie::class);
        $deleteMovieCommand = new DeleteMovieCommand($existedMovie->getId());

        $this->getMessageBus()->dispatch($deleteMovieCommand);

        $movieThatHaveToBeDeleted = $this->getRepository(Movie::class)->find($deleteMovieCommand->movieId);
        self::assertNull($movieThatHaveToBeDeleted);
    }
}
