<?php

namespace App\Command\Movie\CreateMovie;

use App\Domain\Booking\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateMovieHandler implements MessageHandlerInterface
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    public function __invoke(CreateMovieCommand $command): Movie
    {
        $movie = new Movie($command->movieDto->name, $command->movieDto->duration);
        $this->movieRepository->save($movie);

        return $movie;
    }
}
