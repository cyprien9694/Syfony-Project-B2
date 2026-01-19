<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/stars')]
class StarController extends AbstractController
{
    #[Route('/', name: 'star_index')]
    public function index(): Response
    {
        return $this->render('star/index.html.twig');
    }
}
