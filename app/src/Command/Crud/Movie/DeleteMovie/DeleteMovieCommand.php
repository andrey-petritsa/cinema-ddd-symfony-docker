<?php

namespace App\Command\Crud\Movie\DeleteMovie;

use Happyr\Validator\Constraint\EntityExist;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

class DeleteMovieCommand
{
    /**
    * @Assert\NotBlank
    * @EntityExist(entity="App\Domain\Booking\Entity\Movie")
    */
    public UuidInterface $id;

    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }
}
