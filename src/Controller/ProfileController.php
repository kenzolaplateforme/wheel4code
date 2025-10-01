<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->getUser()) {
          return $this->redirectToRoute("draw_all");
        }
        $user = $this->getUser();
        $formProfile = $this->createForm(ProfileType::class, $user);

        $formProfile->handleRequest($request);

        if($formProfile->isSubmitted() && $formProfile->isValid()) {
          $file = $formProfile->get('avatar')->getData();
          if($file) {
            $fileSystem = new Filesystem();
            $oldFile = $this->getParameter('avatar_dir')."/".$user->getAvatar();
            $fileSystem->remove($oldFile);
            $newNameFile = uniqid().uniqid().".".$file->guessExtension();
            $user->setAvatar($newNameFile);
            $file->move($this->getParameter('avatar_dir'), $newNameFile);
          }
          $em->flush();
          $this->addFlash("success", "Profil mis à jour");
          return $this->redirectToRoute("app_profile");
        }
        return $this->render('profile/index.html.twig', [
            'formProfile' => $formProfile,
        ]);
    }
}
