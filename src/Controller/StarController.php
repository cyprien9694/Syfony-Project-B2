<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StarController extends AbstractController
{
    #[Route('/star', name: 'app_star')]
    public function index(): Response
    {
        return $this->render('star/index.html.twig', [
            'controller_name' => 'StarController',
        ]);
    }
}
