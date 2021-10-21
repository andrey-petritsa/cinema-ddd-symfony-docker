<?php

namespace App\Controller\Admin;

use App\Command\Crud\Movie\ChangeMovie\ChangeMovieCommand;
use App\Command\Crud\Movie\CreateMovie\CreateMovieCommand;
use App\Command\Crud\Movie\DeleteMovie\DeleteMovieCommand;
use App\Domain\Booking\Entity\Movie;
use App\Domain\Booking\Repository\MovieRepository;
use App\Form\MovieType;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMovieController extends AbstractController
{
    #[Route('/admin/movie/create', name: 'admin_create_movie', methods: ['GET', 'POST'])]
    public function createMovie(Request $request, MovieRepository $movieRepository): Response
    {
        $createMovieCommand = new CreateMovieCommand(Uuid::uuid4());
        $createMovieForm = $this->createForm(MovieType::class, $createMovieCommand);
        $createMovieForm->handleRequest($request);

        if ($createMovieForm->isSubmitted() && $createMovieForm->isValid()) {
            $this->dispatchMessage($createMovieCommand);
        }

        return $this->renderForm('admin/movie/movie.create.twig.html', [
            'createMovieForm' => $createMovieForm,
            'movies' => $movieRepository->findAll()
        ]);
    }

    #[Route('/admin/movie/change/{id}', name: 'admin_change_movie', methods: ['GET', 'POST'])]
    public function changeMovie(Request $request, Movie $movie): Response
    {
        $changeMovieCommand = new ChangeMovieCommand($movie->getId());
        $changeMovieForm = $this->createForm(MovieType::class, $changeMovieCommand);
        $changeMovieForm->handleRequest($request);

        if ($changeMovieForm->isSubmitted() && $changeMovieForm->isValid()) {
            $this->dispatchMessage($changeMovieCommand);
        }

        return $this->renderForm('admin/movie/movie.change.twig.html', [
            'changeMovieForm' => $changeMovieForm
        ]);
    }

    #[Route('/admin/movie/delete/{id}', name: 'admin_delete_movie', methods: ['GET', 'POST'])]
    public function deleteMovie(Movie $movie): Response
    {
        $deleteMovieCommand = new DeleteMovieCommand($movie->getId());
        $this->dispatchMessage($deleteMovieCommand);

        return $this->redirectToRoute('admin_create_movie');
    }
}
