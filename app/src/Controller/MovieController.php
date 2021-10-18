<?php

namespace App\Controller;

use App\Command\Movie\ChangeMovie\ChangeMovieCommand;
use App\Command\Movie\CreateMovie\CreateMovieCommand;
use App\Command\Movie\DeleteMovie\DeleteMovieCommand;
use App\Domain\Booking\TransferObject\MovieDto;
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
    public function createMovie(Request $request, MessageBusInterface $bus): Response
    {
        $requestBody = $request->toArray();

        $movieDto = new MovieDto($requestBody['name'], $requestBody['duration']);
        $createMovieMessage = $this->dispatchMessage(new CreateMovieCommand($movieDto));
        $movie = $createMovieMessage->last(HandledStamp::class)->getResult();

        return new JsonResponse(['id' => $movie->getId()]);
    }

    #[Route('/movie', methods: ['GET'])]
    public function getMovies(Request $request, MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        //TODO serialize movie with Symfony\Component\Serializer\Normalizer\DateIntervalNormalizer?
        return JsonResponse::fromJsonString($this->serializer->serialize($movies, 'json'));
    }

    #[Route('/movie', methods: ['PUT'])]
    public function changeMovie(Request $request): Response
    {
        $requestBody = $request->toArray();

        $requestMovie = new MovieDto($requestBody['name'], $requestBody['duration']);
        $toChangeMovieId = Uuid::fromString($requestBody['id']);

        $changeMovieMessage = $this->dispatchMessage(new ChangeMovieCommand($toChangeMovieId, $requestMovie));
        $movie = $changeMovieMessage->last(HandledStamp::class)->getResult();

        return new JsonResponse(['id' => $movie->getId()]);
    }

    #[Route('/movie', methods: ['DELETE'])]
    public function removeMovie(Request $request): Response
    {
        $requestBody = $request->toArray();

        $toDeleteMovieId = Uuid::fromString($requestBody['id']);

        $deleteMovieMessage = $this->dispatchMessage(new DeleteMovieCommand($toDeleteMovieId));
        $movie = $deleteMovieMessage->last(HandledStamp::class)->getResult();

        return new JsonResponse(['id' => $movie->getId()]);
    }

}
