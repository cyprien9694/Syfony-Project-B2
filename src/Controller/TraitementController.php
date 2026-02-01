<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TraitementController extends AbstractController
{
    #[Route('/contact/confirmation/{id}', name: 'app_contact_confirmation')]
    public function confirmation(Contact $contact): Response
    {
        return $this->render('traitement.html.twig', [
            'name'    => $contact->getName(),
            'email'   => $contact->getEmail(),
            'subject' => $contact->getSubject(),
            'message' => $contact->getMessage(),
        ]);
    }
}
