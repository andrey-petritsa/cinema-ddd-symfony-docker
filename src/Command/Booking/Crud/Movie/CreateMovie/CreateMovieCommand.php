<?php

namespace App\Command\Booking\Crud\Movie\CreateMovie;

use Symfony\Component\Validator\Constraints as Assert;

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

    //QUESTION для типа DateInеerval я не нашел Constraint
    // Нужно пользоваться самописным решением / библиотекой или есть решение лучше?
    /**
     * @Assert\NotBlank
     **/
    public $duration;

    public function __construct($id)
    {
        $this->movieId = $id;
    }
}
