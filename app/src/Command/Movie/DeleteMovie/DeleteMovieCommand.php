<?php

namespace App\Command\Movie\DeleteMovie;

use Ramsey\Uuid\UuidInterface;

class DeleteMovieCommand
{
    public function __construct(public UuidInterface $id)
    {
    }
}
