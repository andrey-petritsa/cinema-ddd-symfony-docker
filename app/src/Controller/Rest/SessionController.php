<?php

namespace App\Controller\Rest;

use App\Command\Crud\Session\ChangeSession\ChangeSessionCommand;
use App\Command\Crud\Session\CreateSession\CreateSessionCommand;
use App\Command\Crud\Session\DeleteSession\DeleteSessionCommand;
use App\Domain\Booking\Entity\Session\Session;
use App\Repository\SessionRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', methods: ['GET'])]
    public function getSessions(Request $request, SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findAll();

        return new JsonResponse($sessions);
    }

    #[Route('/session', methods: ['POST'])]
    public function createSession(Request $request, SessionRepository $sessionRepository): Response
    {
        $requestBody = $request->toArray();

        $sessionId = Uuid::uuid4();
        $createSessionCommand = new CreateSessionCommand($sessionId, $requestBody['movieId'], $requestBody['numberOfSeats'], $requestBody['startAt']);
        $this->dispatchMessage($createSessionCommand);

        $session = $sessionRepository->find($sessionId);

        return new JsonResponse($session->getId());
    }

    #[Route('/session/{id}', methods: ['PUT'])]
    public function changeSession(Request $request, Session $session): Response
    {
        $requestBody = $request->toArray();

        $changeSessionCommand = new ChangeSessionCommand($session->getId(), $requestBody['movieId'], $requestBody['numberOfSeats'], $requestBody['startAt']);
        $this->dispatchMessage($changeSessionCommand);

        return new JsonResponse($session->getId());
    }

    #[Route('/session/{id}', methods: ['DELETE'])]
    public function deleteSession(Session $session, SessionRepository $sessionRepository): Response
    {
        $sessionId = $session->getId();
        $deleteSessionCommand = new DeleteSessionCommand($sessionId);
        $this->dispatchMessage($deleteSessionCommand);

        $session = $sessionRepository->find($sessionId);

        if (!$session) {
            return new JsonResponse($sessionId);
        }

        throw new \Exception('Не удалось удалить сессию');
    }
}
