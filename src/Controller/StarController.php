<?php

namespace App\Controller;

use App\Entity\Star;
use App\Entity\Category;
use App\Form\StarType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StarController extends AbstractController
{
    #[Route('/star', name: 'app_star')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        // Récupérer le paramètre de filtre depuis l'URL
        $categoryId = $request->query->get('category');

        // Récupérer toutes les catégories pour le select
        $categories = $em->getRepository(Category::class)->findAll();

        // Récupérer les étoiles selon le filtre
        if ($categoryId && $categoryId !== 'all') {
            // Filtrer par catégorie spécifique
            $stars = $em->getRepository(Star::class)->findBy(
                ['category' => $categoryId],
                ['createdAt' => 'DESC']
            );
        } else {
            // Récupérer toutes les étoiles
            $stars = $em->getRepository(Star::class)->findBy([], ['createdAt' => 'DESC']);
        }

        return $this->render('star/index.html.twig', [
            'stars' => $stars,
            'categories' => $categories,
            'selectedCategory' => $categoryId ?: 'all',
        ]);
    }
    #[Route('/star/new', name: 'star_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $star = new Star();
        $form = $this->createForm(StarType::class, $star);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($star);
            $em->flush();

            $this->addFlash('success', 'Étoile ajoutée ! 🌟');
            return $this->redirectToRoute('app_star');
        }

        return $this->render('star/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/star/edit/{id}', name: 'star_edit')]
    public function edit(Star $star, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(StarType::class, $star);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Étoile mise à jour ! 🌟');
            return $this->redirectToRoute('app_star');
        }

        return $this->render('star/edit.html.twig', [
            'form' => $form->createView(),
            'star' => $star,
        ]);
    }

    #[Route('/star/delete/{id}', name: 'star_delete', methods: ['POST'])]
    public function delete(Request $request, Star $star, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $star->getId(), $request->request->get('_token'))) {
            $em->remove($star);
            $em->flush();
            $this->addFlash('success', 'Étoile supprimée ! ❌');
        }

        return $this->redirectToRoute('app_star');
    }
    
    #[Route('/star/{id}', name: 'star_show')]
    public function show(Star $star): Response
    {
        return $this->render('star/show.html.twig', [
            'star' => $star,
        ]);
    }
}
