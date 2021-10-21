<?php

namespace App\Command\Booking\Crud\Movie\CreateMovie;

use App\Domain\Booking\Entity\Movie;
use App\Domain\Booking\Repository\MovieRepository;
use DateInterval;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateMovieHandler implements MessageHandlerInterface
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    public function __invoke(CreateMovieCommand $command)
    {
        $movie = new Movie($command->movieId, $command->name, new DateInterval($command->duration));

        $this->movieRepository->save($movie);
    }
}
