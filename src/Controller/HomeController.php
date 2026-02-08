<?php

namespace App\Controller;

use App\Entity\StarOfTheDay;
use App\Repository\StarOfTheDayRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
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

    #[Route('/hello/{name}', name: 'app_hello')]
    public function hello(string $name): Response
    {
        return $this->render('home/hello.html.twig', [
            'name' => ucfirst($name),
        ]);
    }

    #[Route('/star-of-the-day', name: 'app_star_day')]
    public function starOfTheDay(StarOfTheDayRepository $repository): Response
    {
        // Récupère les étoiles du jour visibles le soir
        $stars = $repository->findTodayStars();

        return $this->render('home/star_of_the_day.html.twig', [
            'stars' => $stars,
        ]);
    }

    #[Route('/star-of-the-day/{id}/seen', name: 'star_seen', methods: ['POST'])]
    public function markSeen(
        StarOfTheDay $star,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        // Vérifie le token CSRF
        if ($this->isCsrfTokenValid('seen' . $star->getId(), $request->request->get('_token'))) {
            // Bascule l’état "vue" (checked/unchecked)
            $star->setSeen(!$star->isSeen());
            $em->flush();
        }

        // Redirige vers la page des étoiles du jour
        return $this->redirectToRoute('app_star_day');
    }
}
