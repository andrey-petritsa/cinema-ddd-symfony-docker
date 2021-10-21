<?php

namespace App\Command\Crud\Movie\ChangeMovie;

use App\Domain\Booking\Repository\MovieRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ChangeMovieHandler implements MessageHandlerInterface
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    public function __invoke(ChangeMovieCommand $command)
    {
        $movie = $this->movieRepository->find($command->movieId);
        $movie->setName($command->name);
        $movie->setDuration(new \DateInterval($command->duration));

        $this->movieRepository->save($movie);
    }
}
