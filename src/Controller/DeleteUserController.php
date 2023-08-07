<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteUserController extends AbstractController
{
    #[Route('/delete/user', name: 'app_delete_user', methods: ['GET','POST'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if ($user instanceof \App\Entity\User) {
            // Supprimer la session en cours
            $session = new Session();
            $session->invalidate();

            // Supprimer le user de la base de données
            $entityManager->remove($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_logout'); 
        }

        // Gérer le cas où l'utilisateur n'est pas connecté ou n'est pas une instance de User

        return $this->render('delete_user/index.html.twig', [
            'controller_name' => 'DeleteUserController',
        ]);
    }
}

