<?php

namespace App\Command\Movie\ChangeMovie;

use App\Domain\Booking\TransferObject\MovieDto;
use Ramsey\Uuid\UuidInterface;

class ChangeMovieCommand
{
    public function __construct(public UuidInterface $id, public MovieDto $movie)
    {
    }
}
