<?php

namespace App\Tests\Command\Booking\Crud\Movie;

use App\Command\Booking\Crud\Movie\ChangeMovie\ChangeMovieCommand;
use App\Command\Booking\Crud\Movie\CreateMovie\CreateMovieCommand;
use App\Domain\Booking\Entity\Movie;
use PHPUnit\Framework\Assert;

trait MovieTestTrait
{
    private function assertEqualsCommandWithMovie(
        CreateMovieCommand|ChangeMovieCommand $command,
        Movie $movie
    ) {
        Assert::assertEquals($command->movieId, $movie->getId());
        Assert::assertEquals($command->name, $movie->getName());
        Assert::assertEquals(new \DateInterval($command->duration), $movie->getDuration());
    }
}
