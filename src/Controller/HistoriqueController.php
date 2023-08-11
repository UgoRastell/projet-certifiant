<?php

namespace App\Controller;

use App\Repository\HistoriqueRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/historique')]
class HistoriqueController extends AbstractController
{
    #[Route('/', name: 'app_historique_index', methods: ['GET'])]
    public function index(HistoriqueRepository $historiqueRepository): Response
    {
        // Utilisez $this->getUser() pour obtenir l'objet User
        $user = $this->getUser();
        
        // Utilisez l'ID de l'utilisateur pour la recherche
        $historiques = $historiqueRepository->findBy(['id_user' => $user]);
        
        return $this->render('historique/index.html.twig', [
            'historiques' => $historiques,
        ]);
    }
}

