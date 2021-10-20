<?php

namespace App\Controller\Page;

use App\Command\DomainCases\BookTicket\BookTicketCommand;
use App\Domain\Booking\Entity\Session\Session;
use App\Form\UserType;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingPageController extends AbstractController
{
    //QUESTION можно ли было сделать как в макете? Форму на этой же странице
    #[Route('/', methods: ['GET'], name: 'user_show_sessions')]
    public function index(Request $request, SessionRepository $sessionRepository): Response
    {
        return $this->render('page/index.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

    #[Route('/session/book/{id}', methods: ['GET', 'POST'], name: 'user_book_ticket')]
    public function bookPage(Session $session, Request $request)
    {
        $bookTicketCommand = new BookTicketCommand($session->getId());
        $form = $this->createForm(UserType::class, $bookTicketCommand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dispatchMessage($bookTicketCommand);
            $this->addFlash('success', 'Билет был зарезервирован');
            return $this->redirectToRoute('user_show_sessions');
        }

        return $this->renderForm('page/booking.html.twig', [
            'form' => $form,
        ]);
    }
}