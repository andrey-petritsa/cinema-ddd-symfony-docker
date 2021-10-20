<?php

namespace App\Controller\Page;

use App\Command\Movie\CreateMovie\CreateMovieCommand;
use App\Repository\MovieRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\MovieType;

class AdminController extends AbstractController
{
    #[Route('/admin/movie', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $createMovieCommand = new CreateMovieCommand(Uuid::uuid4(), 'Название фильма', "PT2H25M");
        $form = $this->createForm(MovieType::class, $createMovieCommand);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->dispatchMessage($createMovieCommand);
        }

        return $this->renderForm('admin/movie.twig.html', [
            'form' => $form
        ]);
    }
}
