<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ConstellationController extends AbstractController
{
    #[Route('/constellation', name: 'app_constellation')]
    public function index(): Response
    {
        return $this->render('constellation/index.html.twig', [
            'controller_name' => 'ConstellationController',
        ]);
    }
}
