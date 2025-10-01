<?php

namespace App\Controller;

use App\Entity\Draw;
use App\Form\DrawType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DrawController extends AbstractController
{
    #[Route('/draw', name: 'draw_all')]
    public function index(Request $request, EntityManagerInterface $em,UserRepository $userRepo): Response
    {
      $user = $this->getUser();

      $users = $userRepo ->findBy([], ['username' => 'ASC']);

      $draw = new Draw();

      $drawForm = $this->createForm(DrawType::class, $draw);

      $drawForm->handleRequest($request);

      if ($drawForm->isSubmitted() && $drawForm->isValid()) {
        $em->persist($draw);
        $em->flush();
      }

        return $this->render('draw/index.html.twig', [
            'drawForm' => $drawForm,
            'users' => $users
        ]);
    }


    #[Route('/draw/new', name: 'draw_new')]
    public function new(Request $request, EntityManagerInterface $em,UserRepository $userRepo)
    {
      $draw = new Draw();



      // $drawForm = $this->createForm(DrawType::class, $draw);

      // $drawForm->handleRequest($request);

      // if ($drawForm->isSubmitted() && $drawForm->isValid()) {
      //   $em->persist($draw);
      //   $em->flush();
      // }

      return $this->render("/draw/new.html.twig", [
        "users" => $users,
      ]);
    }
}
