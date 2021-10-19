<?php

namespace App\Controller;

use App\Command\Movie\ChangeMovie\ChangeMovieCommand;
use App\Command\Movie\CreateMovie\CreateMovieCommand;
use App\Command\Movie\DeleteMovie\DeleteMovieCommand;
use App\Domain\Booking\Entity\Movie;
use App\Repository\MovieRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class MovieController extends AbstractController
{
    //TODO delete dependencies here
    public function __construct(private SerializerInterface $serializer)
    {
    }

    #[Route('/movie', methods: ['POST'])]
    public function createMovie(Request $request, MovieRepository $movieRepository): Response
    {
        $requestBody = $request->toArray();

        $movieId = Uuid::uuid4();
        $createMovieCommand = new CreateMovieCommand($movieId, $requestBody['name'], $requestBody['duration']);
        $this->dispatchMessage($createMovieCommand);

        $movie = $movieRepository->find($movieId);

        return new JsonResponse($movie->getId());
    }

    #[Route('/movie', methods: ['GET'])]
    public function getMovies(Request $request, MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        //TODO serialize movie with Symfony\Component\Serializer\Normalizer\DateIntervalNormalizer?
        return JsonResponse::fromJsonString($this->serializer->serialize($movies, 'json'));
    }

    #[Route('/movie/{id}', methods: ['PUT'])]
    public function changeMovie(Request $request, Movie $movie): Response
    {
        $requestBody = $request->toArray();

        $changeMovieCommand = new ChangeMovieCommand($movie->getId(), $requestBody['name'], $requestBody['duration']);
        $this->dispatchMessage($changeMovieCommand);

        return new JsonResponse($movie->getId());
    }

    #[Route('/movie/{id}', methods: ['DELETE'])]
    public function removeMovie(Movie $movie, MovieRepository $movieRepository): Response
    {
        $movieId = $movie->getId();

        $deleteMovieCommand = new DeleteMovieCommand($movieId);
        $this->dispatchMessage($deleteMovieCommand);

        $movie = $movieRepository->find($movieId);

        if (!$movie) {
            return new JsonResponse($movieId);
        }

        throw new \Exception('Не удалось удалить фильм');
    }
}
