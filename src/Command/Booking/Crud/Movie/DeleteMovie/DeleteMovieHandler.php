<?php

namespace App\Command\Booking\Crud\Movie\DeleteMovie;

use App\Domain\Booking\Repository\MovieRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteMovieHandler implements MessageHandlerInterface
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    public function __invoke(DeleteMovieCommand $command)
    {
        $movie = $this->movieRepository->find($command->movieId);
        $this->movieRepository->delete($movie);

        return $movie;
    }
}
