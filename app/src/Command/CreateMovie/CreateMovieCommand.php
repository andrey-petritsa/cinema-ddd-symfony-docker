<?php

namespace App\Command\CreateMovie;

class CreateMovieCommand
{
    public function __construct(public string $name, public string $duration)
    {
    }
}
