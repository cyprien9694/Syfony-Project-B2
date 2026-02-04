<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    // Route pour afficher le formulaire et traiter le POST
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, EntityManagerInterface $em): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('app_contact_confirmation', [
                'id' => $contact->getId(),
            ]);
        }

        return $this->render('contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Route pour afficher la confirmation après l'enregistrement
    #[Route('/contact/confirmation/{id}', name: 'app_contact_confirmation')]
    public function confirmation(int $id, EntityManagerInterface $em): Response
    {
        $contact = $em->getRepository(Contact::class)->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Message introuvable.');
        }

        return $this->render('traitement.html.twig', [
            'name'    => $contact->getName(),
            'email'   => $contact->getEmail(),
            'subject' => $contact->getSubject(),
            'message' => $contact->getMessage(),
        ]);
    }
}
