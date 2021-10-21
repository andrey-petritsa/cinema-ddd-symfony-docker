<?php

namespace App\Controller\Page;

use App\Command\Booking\BookTicket\BookTicketCommand;
use App\Domain\Booking\Entity\Session\Session;
use App\Domain\Booking\Repository\SessionRepository;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingPageController extends AbstractController
{
    //QUESTION можно ли было сделать как в макете? Форму на этой же странице
    #[Route('/', name: 'user_show_sessions', methods: ['GET'])]
    public function index(SessionRepository $sessionRepository): Response
    {
        return $this->render('page/index.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

    #[Route('/session/book/{id}', name: 'user_book_ticket', methods: ['GET', 'POST'])]
    public function bookPage(Session $session, Request $request): Response
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
