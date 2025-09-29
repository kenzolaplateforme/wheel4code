<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DrawController extends AbstractController
{
    #[Route('/draw', name: 'app_draw')]
    public function index(): Response
    {
        return $this->render('draw/index.html.twig', [
            'controller_name' => 'DrawController',
        ]);
    }
}
