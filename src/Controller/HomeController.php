<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Types de champs du formulaire
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/about', name: 'app_about')]
    public function about(Request $request): Response
    {
        // Création du formulaire
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('subject', TextType::class, [
                'label' => 'Sujet',
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Envoyer',
            ])
            ->getForm();

        // Traiter la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Ici tu peux faire quelque chose avec les données, comme envoyer un email
            $this->addFlash('success', 'Message envoyé !');

            // Rediriger pour éviter le double envoi
            return $this->redirectToRoute('app_about');
        }

        return $this->render('home/about.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/hello/{name}', name: 'app_hello')]
    public function hello(string $name): Response
    {
        return $this->render('home/hello.html.twig', [
            'name' => ucfirst($name),
        ]);
    }

    #[Route('/star-of-the-day', name: 'app_star_day')]
    public function starOfTheDay(): Response
    {
        $stars = [
            'Sirius',
            'Canopus',
            'Vega',
            'Arcturus',
            'Rigel',
        ];

        return $this->render('home/star_of_the_day.html.twig', [
            'star' => $stars[array_rand($stars)],
        ]);
    }
}
