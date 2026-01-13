<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('home/about.html.twig');
    }

    #[Route('/hello/{name}', name: 'app_hello')]
    public function hello(string $name): Response
    {
        return $this->render('home/hello.html.twig', [
            'name' => ucfirst($name),
        ]);
    }

    #[Route('/star-of-the-day', name: 'app_random')]
    public function random(): Response
    {
        $stars = [
            "Sirius",
            "Canopus",
            "Arcturus",
            "Vega",
            "Capella",
            "Rigel",
            "Procyon",
        ];

        return $this->render('home/star_of_the_day.html.twig', [
            'citation' => $stars[array_rand($stars)],
        ]);
    }

    #[Route('/api/random', name: 'app_api_random')]
    public function apiRandom(): JsonResponse
    {
        $stars = [
            "Sirius",
            "Canopus",
            "Arcturus",
            "Vega",
            "Capella",
            "Rigel",
            "Procyon",
        ];

        return new JsonResponse([
            'star' => $stars[array_rand($stars)],
        ]);
    }

    #[Route('/redirect', name: 'app_redirect')]
    public function redirectToRandom(): Response
    {
        return $this->redirectToRoute('app_random');
    }

    #[Route('/error', name: 'app_error')]
    public function error(): void
    {
        throw new NotFoundHttpException('Page non trouvée 😢');
    }
}
