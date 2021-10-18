<?php

namespace App\Command\Movie\DeleteMovie;

use App\Repository\MovieRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteMovieHandler implements MessageHandlerInterface
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    public function __invoke(DeleteMovieCommand $command)
    {
        $movie = $this->movieRepository->find($command->id);

        if (!$movie) {
            throw new NotFoundHttpException('Фильма с таким id не существует');
        }

        $this->movieRepository->delete($movie);

        return $movie;
    }
}
