<?php

namespace App\Tests\Command\Booking\Crud\Movie\CreateMovie;

use App\Command\Booking\Crud\Movie\CreateMovie\CreateMovieCommand;
use App\Domain\Booking\Entity\Movie;
use App\Tests\Command\Booking\Crud\Movie\MovieTestTrait;
use App\Tests\CommandWebTestCase;
use Ramsey\Uuid\Uuid;

class CreateMovieHandlerTest extends CommandWebTestCase
{
    use MovieTestTrait;

    /** @test */
    public function canHandleCreateMovie()
    {
        $createMovieCommand = new CreateMovieCommand(Uuid::uuid4());
        $createMovieCommand->name = 'Тестовый фильм';
        $createMovieCommand->duration = 'PT2H1M';

        $this->getMessageBus()->dispatch($createMovieCommand);
        $createdMovie = $this->getRepository(Movie::class)->find($createMovieCommand->movieId);

        $this->assertEqualsCommandWithMovie($createMovieCommand, $createdMovie);
    }
}
