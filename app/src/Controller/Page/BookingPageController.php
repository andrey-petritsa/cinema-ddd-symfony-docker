<?php

namespace App\Controller\Page;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingPageController extends AbstractController
{
    #[Route( '/', methods: ['GET'] )]
    public function index(Request $request): Response
    {
        return new Response();
    }
}
