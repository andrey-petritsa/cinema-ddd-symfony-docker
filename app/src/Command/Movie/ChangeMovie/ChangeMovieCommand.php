<?php

namespace App\Command\Movie\ChangeMovie;

use App\Domain\Booking\TransferObject\MovieDto;
use Happyr\Validator\Constraint\EntityExist;
use Ramsey\Uuid\UuidInterface;
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

    public function __construct($id, $name, $duration)
    {
        $this->id = $id;
        $this->name = $name;
        $this->duration = $duration;
    }

}
