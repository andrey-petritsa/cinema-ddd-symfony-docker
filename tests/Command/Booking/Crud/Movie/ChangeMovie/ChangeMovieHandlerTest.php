<?php

namespace App\Tests\Command\Booking\Crud\Movie\ChangeMovie;

use App\Command\Booking\Crud\Movie\ChangeMovie\ChangeMovieCommand;
use App\Domain\Booking\Entity\Movie;
use App\Tests\Command\Booking\Crud\Movie\MovieTestTrait;
use App\Tests\CommandWebTestCase;

class ChangeMovieHandlerTest extends CommandWebTestCase
{
    use MovieTestTrait;

    /** @test */
    public function changeMovieHandled()
    {
        $movieForChange = $this->getRandomEntity(Movie::class);
        $changeMovieCommand = new ChangeMovieCommand($movieForChange->getId());
        $changeMovieCommand->name = 'Измененное название';
        $changeMovieCommand->duration = 'PT1H2M';

        $this->getMessageBus()->dispatch($changeMovieCommand);

        $this->assertEqualsCommandWithMovie($changeMovieCommand, $movieForChange);
    }
}