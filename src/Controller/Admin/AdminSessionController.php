<?php

namespace App\Controller\Admin;

use App\Command\Crud\Session\ChangeSession\ChangeSessionCommand;
use App\Command\Crud\Session\CreateSession\CreateSessionCommand;
use App\Command\Crud\Session\DeleteSession\DeleteSessionCommand;
use App\Domain\Booking\Entity\Session\Session;
use App\Domain\Booking\Repository\SessionRepository;
use App\Form\SessionType;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminSessionController extends AbstractController
{
    #[Route('/admin/session/create', name: 'admin_create_session', methods: ['GET', 'POST'])]
    public function createSession(Request $request, SessionRepository $sessionRepository): Response
    {
        $createSessionCommand = new createSessionCommand(Uuid::uuid4());
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

    #[Route('/admin/session/change/{id}', name: 'admin_change_session', methods: ['GET', 'POST'])]
    public function changeSession(Request $request, Session $session): Response
    {
        $changeSessionCommand = ChangeSessionCommand::createFromSession($session);

        $changeSessionForm = $this->createForm(SessionType::class, $changeSessionCommand);
        $changeSessionForm->handleRequest($request);

        if ($changeSessionForm->isSubmitted() && $changeSessionForm->isValid()) {
            $this->dispatchMessage($changeSessionCommand);
        }

        return $this->renderForm('admin/session/session.change.twig.html', [
            'changeSessionForm' => $changeSessionForm,
        ]);
    }

    #[Route('/admin/session/delete/{id}', name: 'admin_delete_session', methods: ['GET'])]
    public function deleteSession(Session $session): Response
    {
        $deleteSessionCommand = new DeleteSessionCommand($session->getId());
        $this->dispatchMessage($deleteSessionCommand);

        return $this->redirectToRoute('admin_create_session');
    }
}
