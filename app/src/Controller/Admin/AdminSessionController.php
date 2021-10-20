<?php

namespace App\Controller\Admin;

use App\Command\Movie\ChangeMovie\ChangeMovieCommand;
use App\Command\Session\ChangeSession\ChangeSessionCommand;
use App\Command\Session\CreateSession\CreateSessionCommand;
use App\Domain\Booking\Entity\Session\Session;
use App\Form\SessionType;
use App\Repository\MovieRepository;
use App\Repository\SessionRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminSessionController extends AbstractController
{
    #[Route('/admin/session/create', methods: ['GET', 'POST'], name: 'admin_create_session')]
    public function createSession(Request $request, MovieRepository $movieRepository, SessionRepository $sessionRepository): Response
    {
        $firstMovie = $movieRepository->findOneBy([]);
        $createSessionCommand = new createSessionCommand(Uuid::uuid4(), $firstMovie, 20, "2021-02-02 16:15:00");
        $createSessionForm = $this->createForm(SessionType::class, $createSessionCommand);
        $createSessionForm->handleRequest($request);

        if ($createSessionForm->isSubmitted() && $createSessionForm->isValid()) {
            $this->dispatchMessage($createSessionCommand);
        }

        return $this->renderForm('admin/session/session.create.twig.html', [
            'createSessionForm' => $createSessionForm,
            'sessions' => $sessionRepository->findAll()
        ]);
    }

    #[Route('/admin/session/change/{id}', methods: ['GET', 'POST'], name: 'admin_change_session')]
    public function changeSession(Request $request, Session $session): Response
    {
        $startAt = $session->getStartAt()->format('Y-m-d H:i:s');
        $changeSessionCommand = new ChangeSessionCommand($session->getId(), $session->getMovie(), $session->getNumberOfSeats(), $startAt);
        $changeSessionForm = $this->createForm(SessionType::class, $changeSessionCommand);
        $changeSessionForm->handleRequest($request);

        if ($changeSessionForm->isSubmitted() && $changeSessionForm->isValid()) {
            $this->dispatchMessage($changeSessionCommand);
        }

        return $this->renderForm('admin/session/session.change.twig.html', [
            'changeSessionForm' => $changeSessionForm,
        ]);
    }
}
