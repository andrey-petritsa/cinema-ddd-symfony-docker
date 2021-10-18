<?php

namespace App\Command\CreateMovie;

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
        $duration = new \DateInterval($command->duration);
        $movie = new Movie($command->name, $duration);
        $this->movieRepository->save($movie);

        return $movie;
    }
}
