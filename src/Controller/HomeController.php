<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
