<?php

namespace App\Controller;

use App\Service\MovieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    public function __construct(private MovieService $movieService)
    {
    }

    #[Route('/movie', methods: ['POST'])]
    public function createMovie(Request $request): Response
    {
        $requestBody = $request->toArray();
        $movie = $this->movieService->publishMovie($requestBody['name'], $requestBody['duration']);

        return $this->json(['id' => $movie->getId()]);
    }

    #[Route( '/movie', methods: ['GET'] )]
    public function getMovies (Request $request): Response
    {
        return $this->json([
            'name' => 'hello'
        ]);
    }

}
