<?php

namespace App\Command\Crud\Movie\CreateMovie;

use App\Domain\Booking\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateMovieHandler implements MessageHandlerInterface
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    public function __invoke(CreateMovieCommand $command)
    {
        $movie = new Movie($command->movieId, $command->name, new \DateInterval($command->duration));

        $this->movieRepository->save($movie);
    }
}
