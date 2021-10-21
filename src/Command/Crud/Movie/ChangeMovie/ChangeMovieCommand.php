<?php

namespace App\Command\Crud\Movie\ChangeMovie;

use Happyr\Validator\Constraint\EntityExist;
use Symfony\Component\Validator\Constraints as Assert;

class ChangeMovieCommand
{
    /**
     * @Assert\NotBlank
     * @EntityExist(entity="App\Domain\Booking\Entity\Movie")
     * */
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
