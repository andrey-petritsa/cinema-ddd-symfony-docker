<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use App\Service\MovieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MovieController extends AbstractController
{
    public function __construct(private MovieService $movieService, private MovieRepository $movieRepository, private SerializerInterface $serializer)
    {
    }

    #[Route('/movie', methods: ['POST'])]
    public function createMovie(Request $request): Response
    {
        $requestBody = $request->toArray();
        //TODO make as command
        $movie = $this->movieService->publishMovie($requestBody['name'], $requestBody['duration']);

        return $this->json(['id' => $movie->getId()]);
    }

    #[Route('/movie', methods: ['GET'])]
    public function getMovies(Request $request): Response
    {
        $movies = $this->movieRepository->findAll();

        //TODO serialize movie
        return JsonResponse::fromJsonString($this->serializer->serialize($movies, 'json'));
    }

}
