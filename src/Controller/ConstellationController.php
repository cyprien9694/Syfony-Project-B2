<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/constellations')]
class ConstellationController extends AbstractController
{
    #[Route('/', name: 'constellation_index')]
    public function index(): Response
    {
        return $this->render('constellation/index.html.twig');
    }
}