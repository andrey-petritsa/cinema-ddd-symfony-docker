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
        /** @var Movie $movie */
        $movie = $this->movieRepository->find($command->id);

        //QUESTION Можно ли делать проверку прямо здесь?
        if (!$movie) {
            throw new NotFoundHttpException('Фильма с таким id не существует');
        }

        $movie->setName($command->movie->name);
        $movie->setDuration($command->movie->duration);

        $this->movieRepository->save($movie);

        return $movie;
    }
}
