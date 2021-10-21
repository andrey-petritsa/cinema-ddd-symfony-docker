<?php

namespace App\Controller\Rest;

use App\Command\Crud\Movie\ChangeMovie\ChangeMovieCommand;
use App\Command\Crud\Movie\CreateMovie\CreateMovieCommand;
use App\Command\Crud\Movie\DeleteMovie\DeleteMovieCommand;
use App\Domain\Booking\Entity\Movie;
use App\Domain\Booking\Repository\MovieRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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
        $createMovieCommand = new CreateMovieCommand($movieId);
        $createMovieCommand->name = $requestBody['name'];
        $createMovieCommand->duration = $requestBody['duration'];
        $this->dispatchMessage($createMovieCommand);

        $movie = $movieRepository->find($movieId);

        return new JsonResponse($movie->getId());
    }

    #[Route('/movie', methods: ['GET'])]
    public function getMovies(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        return JsonResponse::fromJsonString($this->serializer->serialize($movies, 'json'));
    }

    #[Route('/movie/{id}', methods: ['PUT'])]
    public function changeMovie(Request $request, Movie $movie): Response
    {
        $requestBody = $request->toArray();

        $changeMovieCommand = new ChangeMovieCommand($movie->getId());

        $changeMovieCommand->name = $requestBody['name'];
        $changeMovieCommand->duration = $requestBody['duration'];

        $this->dispatchMessage($changeMovieCommand);

        return new JsonResponse($movie->getId());
    }

    #[Route('/movie/{id}', methods: ['DELETE'])]
    public function removeMovie(Movie $movie, MovieRepository $movieRepository): Response
    {
        $movieId = $movie->getId();

        $deleteMovieCommand = new DeleteMovieCommand($movieId);
        $this->dispatchMessage($deleteMovieCommand);

        $deletedMovie = $movieRepository->find($movieId);

        if (!$deletedMovie) {
            return new JsonResponse($movieId);
        }

        throw new \Exception('Не удалось удалить фильм');
    }
}
