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
    public $id;
    public $name;
    public $duration;

    public function __construct($id)
    {
        $this->id = $id;
    }

}
