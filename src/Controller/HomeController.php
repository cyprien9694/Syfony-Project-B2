<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return new Response('<h1>Bienvenue sur mon application Symfony</h1>');
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('home/about.html.twig');
    }

    #[Route('/hello/{name}', name: 'app_hello')]
    public function hello(string $name): Response
    {
        $name = ucfirst($name);
        return $this->render('home/hello.html.twig', ['name' => $name]);
    }

    #[Route('/random', name: 'app_random')]
    public function random(): Response
    {
        // Tableau de citations
        $citations = [
            "La vie est un mystère qu'il faut vivre, et non un problème à résoudre.",
            "Le succès n’est pas la clé du bonheur. Le bonheur est la clé du succès.",
            "Il n’y a qu’une façon d’échouer, c’est d’abandonner avant d’avoir réussi.",
            "La plus grande gloire n’est pas de ne jamais tomber, mais de se relever à chaque chute."
        ];

        // Choisir une citation aléatoire
        $citationDuJour = $citations[array_rand($citations)];

        // Envoyer au template Twig
        return $this->render('home/random.html.twig', [
            'citation' => $citationDuJour
        ]);
    }
}
