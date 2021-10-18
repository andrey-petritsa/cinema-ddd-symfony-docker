<?php

namespace App\Command\Movie\CreateMovie;

use App\Domain\Booking\TransferObject\MovieDto;

class CreateMovieCommand
{
    public function __construct(public MovieDto $movieDto)
    {
    }
}
