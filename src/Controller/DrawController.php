<?php

namespace App\Controller;

use App\Entity\Draw;
use App\Form\DrawType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DrawController extends AbstractController
{
    #[Route('/draw', name: 'draw_all')]
    public function index(): Response
    {
        $user = $this->getUser();

        $userAvatar = $user->getAvatar();

        $draws = $user->getDraw();

        return $this->render('draw/index.html.twig', [
            'userAvatar' => $userAvatar,
        ]);
    }

    #[Route('/draw/new', name: 'draw_new')]
    public function new(Request $request, EntityManagerInterface $em)
    {
      $draw = new Draw();

      $drawForm = $this->createForm(DrawType::class, $draw);

      $drawForm->handleRequest($request);

      if ($drawForm->isSubmitted() && $drawForm->isValid()) {
        $em->persist($draw);
        $em->flush();
      }

      return $this->render("/draw/new.html.twig", ["formDraw" => $drawForm]);
    }
}
