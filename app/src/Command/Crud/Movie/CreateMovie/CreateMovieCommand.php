<?php

namespace App\Command\Crud\Movie\CreateMovie;

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
