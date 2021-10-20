<?php

namespace App\Controller\Admin;

use App\Command\Movie\ChangeMovie\ChangeMovieCommand;
use App\Command\Movie\CreateMovie\CreateMovieCommand;
use App\Domain\Booking\Entity\Movie;
use App\Form\MovieType;
use App\Form\SessionType;
use App\Repository\MovieRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMovieController extends AbstractController
{
    #[Route('/admin/movie/create', methods: ['GET', 'POST'], name: "admin_create_movie")]
    public function createMovie(Request $request, MovieRepository $movieRepository): Response
    {
        //QUESTION есть ли способ не инициализировать значения команды? Нужно отказаться от конструктора в пользу простого обращения
        // к public значениям?
        $createMovieCommand = new CreateMovieCommand(Uuid::uuid4(), 'Название фильма', "PT2H25M");
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

    #[Route('/admin/movie/change/{id}', methods: ['GET', 'POST'], name: 'admin_change_movie')]
    public function changeMovie(Request $request, Movie $movie): Response
    {
        $changeMovieCommand = new ChangeMovieCommand($movie->getId(), $movie->getName(), $movie->getDuration()->format('PT%hH%iM'));
        $changeMovieForm = $this->createForm(MovieType::class, $changeMovieCommand);
        $changeMovieForm->handleRequest($request);

        if ($changeMovieForm->isSubmitted() && $changeMovieForm->isValid()) {
            $this->dispatchMessage($changeMovieCommand);
        }

        return $this->renderForm('admin/movie/movie.change.twig.html', [
            'changeMovieForm' => $changeMovieForm
        ]);
    }
}
