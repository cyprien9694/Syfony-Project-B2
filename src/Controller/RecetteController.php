<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecetteController extends AbstractController
{
    #[Route('/recette/ajouter', name: 'recette_ajouter')]
    public function ajouter(Request $request): Response
    {
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Affiche l'objet dans le Profiler
            dump($recette);

            $this->addFlash('success', 'Recette ajoutée avec succès !');

            // Reset du formulaire pour nouvelle saisie
            return $this->redirectToRoute('recette_ajouter');
        }

        return $this->render('recette/ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
