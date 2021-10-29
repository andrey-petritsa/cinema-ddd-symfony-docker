<?php

namespace App\Tests\Functional\Command\Booking\Crud\Movie\DeleteMovie;

use App\Command\Booking\Crud\Movie\DeleteMovie\DeleteMovieCommand;
use App\DataFixtures\TestMovieFixtures;
use App\Domain\Booking\Entity\Movie;
use App\Tests\Functional\CommandWebTestCase;

class DeleteMovieHandlerTest extends CommandWebTestCase
{
    /** @test */
    public function movieNotExistAfterHandle()
    {
        $this->getDatabaseTool()->loadFixtures([TestMovieFixtures::class]);
        $existedMovie = $this->getOneEntity(Movie::class);
        $deleteMovieCommand = new DeleteMovieCommand($existedMovie->getId());

        $this->getMessageBus()->dispatch($deleteMovieCommand);

        $movieThatHaveToBeDeleted = $this->getRepository(Movie::class)->find($deleteMovieCommand->movieId);
        self::assertNull($movieThatHaveToBeDeleted);
    }
}
