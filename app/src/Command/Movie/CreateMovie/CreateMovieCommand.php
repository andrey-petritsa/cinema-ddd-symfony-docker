<?php

namespace App\Command\Movie\CreateMovie;

use App\Domain\Booking\TransferObject\MovieDto;

class CreateMovieCommand
{
    public $id;
    public $name;
    public $duration;

    public function __construct($id, $name, $duration)
    {
        $this->id = $id;
        $this->name = $name;
        $this->duration = $duration;
    }

}
