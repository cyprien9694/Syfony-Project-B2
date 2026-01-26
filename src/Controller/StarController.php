<?php

namespace App\Controller;

use App\Entity\Star;
use App\Form\StarType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StarController extends AbstractController
{
    #[Route('/star', name: 'app_star')]
    public function index(EntityManagerInterface $em): Response
    {
        $stars = $em->getRepository(Star::class)->findAll();
        return $this->render('star/index.html.twig', [
            'stars' => $stars,
        ]);
    }

    #[Route('/star/new', name: 'star_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $star = new Star();
        $star->setCreatedAt(new \DateTimeImmutable()); // initialisation automatique

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
            $em->flush(); // seul flush() suffit, Doctrine suit déjà l'objet
            $this->addFlash('success', 'Étoile mise à jour ! 🌟');

            return $this->redirectToRoute('app_star');
        }

        return $this->render('star/edit.html.twig', [
            'form' => $form->createView(),
            'star' => $star,
        ]);
    }
    #[Route('/star/delete/{id}', name: 'star_delete')]
    public function delete(Star $star, EntityManagerInterface $em): Response
    {
        if ($star) {
            $em->remove($star);
            $em->flush();
            $this->addFlash('success', 'Étoile supprimée ! ❌');
        }

        return $this->redirectToRoute('app_star');
    }
}
