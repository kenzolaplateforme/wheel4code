<?php

namespace App\Controller;

use App\Entity\Draw;
use App\Form\DrawType;
use App\Repository\UserRepository;
use App\Service\DrawService;
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

      $users = $userRepo ->findBy([], ['username' => 'ASC']);

        return $this->render('draw/index.html.twig', [
            // 'draws' => $draws,
            'users' => $users
        ]);
    }


    #[Route('/draw/new', name: 'draw_new', methods:['POST'])]
    public function new(DrawService $drawService,Request $request, EntityManagerInterface $em,UserRepository $userRepo): Response
    {
      $ids = explode(',', $request->request->get('participants', ''));

      $users = $userRepo ->findBy(['id' => $ids]);

      $draw = new Draw();

      foreach ($users as $user) {
        $draw->addUser($user);
      }

      if($drawService->isValid($draw)) {
        if($this->isCsrfTokenValid('addUser', $request->request->get('_token'))) {
          $em->persist($draw);
          $em->flush();
        } else {
          $this->addFlash("error", "CSRF Token invalide");
          return $this->redirectToRoute("draw_all");
        }
      } else {
        $this->addFlash("error", "Veuillez séléctionner deux utilisateurs minimum");
        return $this->redirectToRoute("draw_all");
      }



      // $drawForm = $this->createForm(DrawType::class, $draw);

      // $drawForm->handleRequest($request);

      // if ($drawForm->isSubmitted() && $drawForm->isValid()) {
      //   $em->persist($draw);
      //   $em->flush();
      // }

      return $this->redirectToRoute('draw_show', ['id' => $draw->getId()]);
    }
     #[Route('/draw/{id}', name: 'draw_show', methods: ['GET'])]
    public function show(Draw $draw): Response
    {

        return $this->render('draw/show.html.twig', [
            'draw' => $draw
        ]);
    }
}
