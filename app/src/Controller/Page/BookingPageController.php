<?php

namespace App\Controller\Page;

use App\Domain\Booking\Entity\Session\Session;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingPageController extends AbstractController
{
    #[Route('/', methods: ['GET'])]
    public function index(Request $request, SessionRepository $sessionRepository): Response
    {
        return $this->render('page/booking.html.twig', [
            'sessions' => $sessionRepository->findAll()
        ]);
    }
}
