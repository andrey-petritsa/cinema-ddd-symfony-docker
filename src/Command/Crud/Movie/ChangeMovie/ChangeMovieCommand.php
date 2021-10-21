<?php

namespace App\Command\Crud\Movie\ChangeMovie;

use App\Domain\Booking\Entity\Movie;
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

    public static function createByMovie(Movie $movie): self
    {
        $changeMovieCommand = new ChangeMovieCommand($movie->getId());
        $changeMovieCommand->name = $movie->getName();
        $changeMovieCommand->duration = $movie->getDuration()->format('PT%hH%iM');

        return $changeMovieCommand;
    }
}
