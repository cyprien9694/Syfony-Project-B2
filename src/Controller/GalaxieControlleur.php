<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/galaxies')]
class GalaxieController extends AbstractController
{
    #[Route('/', name: 'galaxy_index')]
    public function index(): Response
    {
        return $this->render('galaxy/index.html.twig');
    }
}