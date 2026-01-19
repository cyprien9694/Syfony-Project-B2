<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/images')]
class ImageController extends AbstractController
{
    #[Route('/', name: 'image_index')]
    public function index(): Response
    {
        return $this->render('image/index.html.twig');
    }
}