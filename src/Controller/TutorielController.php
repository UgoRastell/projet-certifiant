<?php

namespace App\Controller;

use App\Entity\Tutoriel;
use App\Form\Tutoriel1Type;
use App\Repository\TutorielRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;

#[Route('/tutoriel')]
class TutorielController extends AbstractController
{
    #[Route('/', name: 'app_tutoriel_index', methods: ['GET'])]
    public function index(TutorielRepository $tutorielRepository,Request $request, CategorieRepository $categorieRepository): Response
    {
        $categoryId = $request->query->get('category');
        $categories = $categorieRepository->findAll();
    
        if ($categoryId) {
            $tutoriels = $tutorielRepository->findByCategory($categoryId);
        } else {
            $tutoriels = $tutorielRepository->findAll();
        }
    
        return $this->render('tutoriel/index.html.twig', [
            'tutoriels' => $tutoriels,
            'categories' => $categories,
        ]);
    }

    #[Route('/new', name: 'app_tutoriel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TutorielRepository $tutorielRepository): Response
    {
        $tutoriel = new Tutoriel();
        $form = $this->createForm(Tutoriel1Type::class, $tutoriel);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer les fichiers PDF et vidéo
            $pdfFile = $form['fichier_PDF']->getData();
            $videoFile = $form['fichier_video']->getData();
    
            if ($pdfFile) {
                $pdfFileName = md5(uniqid()) . '.' . $pdfFile->guessExtension();
                $pdfFile->move($this->getParameter('app.upload_PDF'), $pdfFileName);
                $tutoriel->setFichierPDF($pdfFileName); // Assurez-vous d'ajuster cette méthode selon votre entité Tutoriel
            }
    
            if ($videoFile) {
                $videoFileName = md5(uniqid()) . '.' . $videoFile->guessExtension();
                $videoFile->move($this->getParameter('app.upload_video'), $videoFileName);
                $tutoriel->setFichierVideo($videoFileName); // Assurez-vous d'ajuster cette méthode selon votre entité Tutoriel
            }
    
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
        $form = $this->createForm(Tutoriel1Type::class, $tutoriel);
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
        if ($this->isCsrfTokenValid('delete'.$tutoriel->getId(), $request->request->get('_token'))) {
            $tutorielRepository->remove($tutoriel, true);
        }

        return $this->redirectToRoute('app_tutoriel_index', [], Response::HTTP_SEE_OTHER);
    }
}
