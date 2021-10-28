<?php

namespace App\Command\Booking\Crud\Movie\CreateMovie;

use Symfony\Component\Validator\Constraints as Assert;

//TODO перенести дублирование в треиты
class CreateMovieCommand
{
    /**
     * @Assert\NotBlank
     **/
    public $movieId;

    /**
     * @Assert\NotBlank
     **/
    public $name;

    /**
     * @Assert\NotBlank
     **/
    public $duration;

    public function __construct($id)
    {
        $this->movieId = $id;
    }
}
