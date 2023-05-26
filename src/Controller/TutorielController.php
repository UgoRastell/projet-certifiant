<?php

namespace App\Controller;

use App\Entity\Tutoriel;
use App\Form\TutorielType;
use App\Repository\TutorielRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tutoriel')]
class TutorielController extends AbstractController
{
    #[Route('/', name: 'app_tutoriel_index', methods: ['GET'])]
    public function index(TutorielRepository $tutorielRepository): Response
    {
        return $this->render('tutoriel/index.html.twig', [
            'tutoriels' => $tutorielRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tutoriel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TutorielRepository $tutorielRepository): Response
    {
        $tutoriel = new Tutoriel();
        $form = $this->createForm(TutorielType::class, $tutoriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les fichiers PDF et vidéo depuis la requête
            $uploadedPDF = $form->get('fichier_PDF')->getData();
            $uploadedVideo = $form->get('fichier_video')->getData();

            // Pour les fichiers PDF
            $destinationPDF = "";
            if ($uploadedPDF) {
                $destinationPDF = 'uploads/fichiers/' . uniqid() . '.' . $uploadedPDF->getClientOriginalExtension();
                $uploadedPDF->move($this->getParameter('app.upload_directory'), $destinationPDF);
            }

            // Pour les vidéos
            $destinationVideo = "";
            if ($uploadedVideo) {
                $destinationVideo = 'uploads/videos/' . uniqid() . '.' . $uploadedVideo->getClientOriginalExtension();
                $uploadedVideo->move($this->getParameter('app.upload_directory'), $destinationVideo);
            }

            // Enregistrer les chemins des fichiers dans votre entité Tutoriel
            $tutoriel->setFichierPDF($destinationPDF);
            $tutoriel->setFichierVideo($destinationVideo);

            $tutorielRepository->save($tutoriel, true);

            return $this->redirectToRoute('app_tutoriel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tutoriel/new.html.twig', [
            'tutoriel' => $tutoriel,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_tutoriel_show', methods: ['GET'])]
    public function show(Tutoriel $tutoriel): Response
    {
        return $this->render('tutoriel/show.html.twig', [
            'tutoriel' => $tutoriel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tutoriel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tutoriel $tutoriel, TutorielRepository $tutorielRepository): Response
    {
        $form = $this->createForm(TutorielType::class, $tutoriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tutorielRepository->save($tutoriel, true);

            return $this->redirectToRoute('app_tutoriel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tutoriel/edit.html.twig', [
            'tutoriel' => $tutoriel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tutoriel_delete', methods: ['POST'])]
    public function delete(Request $request, Tutoriel $tutoriel, TutorielRepository $tutorielRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tutoriel->getId(), $request->request->get('_token'))) {
            $tutorielRepository->remove($tutoriel, true);
        }

        return $this->redirectToRoute('app_tutoriel_index', [], Response::HTTP_SEE_OTHER);
    }
}
