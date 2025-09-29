<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DrawController extends AbstractController
{
    #[Route('/draw', name: 'draw_all')]
    public function index(): Response
    {
        return $this->render('draw/index.html.twig', [
            'controller_name' => 'DrawController',
        ]);
    }

    #[Route('/draw/new', name: 'draw_new')]
    public function new() {
      dd("test");
    }
}
