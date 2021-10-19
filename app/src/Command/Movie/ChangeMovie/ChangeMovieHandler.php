<?php

namespace App\Command\Movie\ChangeMovie;

use App\Domain\Booking\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ChangeMovieHandler implements MessageHandlerInterface
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    public function __invoke(ChangeMovieCommand $command)
    {
        $movie = $this->movieRepository->find($command->id);
        $movie->setName($command->name);
        $movie->setDuration(new \DateInterval($command->duration));

        $this->movieRepository->save($movie);
    }
}
