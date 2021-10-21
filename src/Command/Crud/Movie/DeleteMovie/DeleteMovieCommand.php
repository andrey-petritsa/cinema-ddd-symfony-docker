<?php

namespace App\Command\Crud\Movie\DeleteMovie;

use Happyr\Validator\Constraint\EntityExist;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteMovieCommand
{
    /**
     * @Assert\NotBlank
     * @EntityExist(entity="App\Domain\Booking\Entity\Movie")
     */
    public $movieId;

    public function __construct($id)
    {
        $this->movieId = $id;
    }
}
