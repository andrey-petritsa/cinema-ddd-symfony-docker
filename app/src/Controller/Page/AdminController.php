<?php

namespace App\Controller\Page;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/movie', methods: ['GET'])]
    public function index(MovieRepository $movieRepository): Response
    {
        return $this->render('admin/movie.twig.html', [
            'movies' => $movieRepository->findAll()
        ]);
    }
}
