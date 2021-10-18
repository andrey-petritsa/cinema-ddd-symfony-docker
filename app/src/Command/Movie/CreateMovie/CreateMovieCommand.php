<?php

namespace App\Command\Movie\CreateMovie;

class CreateMovieCommand
{
    public function __construct(public string $name, public string $duration)
    {
    }
}
