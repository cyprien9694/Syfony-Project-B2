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
#[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
public function contact(Request $request, EntityManagerInterface $em): Response
{
    // Debug: Voir si la méthode atteint cette ligne
    error_log("=== CONTACT CONTROLLER EXECUTED ===");
    error_log("Method: " . $request->getMethod());
    error_log("Path: " . $request->getPathInfo());

    $contact = new Contact();
    $form = $this->createForm(ContactType::class, $contact);

    $form->handleRequest($request);

    // Debug form state
    error_log("Form submitted: " . ($form->isSubmitted() ? 'YES' : 'NO'));
    error_log("Form valid: " . ($form->isValid() ? 'YES' : 'NO'));

    if ($form->isSubmitted()) {
        error_log("Form errors: " . count($form->getErrors(true)));

        if (!$form->isValid()) {
            foreach ($form->getErrors(true) as $error) {
                error_log("Error: " . $error->getMessage());
            }
        }
    }

    if ($form->isSubmitted() && $form->isValid()) {
        error_log("Saving contact to database...");

        try {
            $em->persist($contact);
            $em->flush();
            error_log("Contact saved successfully! ID: " . $contact->getId());

            return $this->render('traitement.html.twig', [
                'name'    => $contact->getName(),
                'email'   => $contact->getEmail(),
                'subject' => $contact->getSubject(),
                'message' => $contact->getMessage(),
            ]);
        } catch (\Exception $e) {
            error_log("Database error: " . $e->getMessage());
            throw $e; // Lancer l'exception pour voir l'erreur
        }
    }

    return $this->render('contact.html.twig', [
        'form' => $form->createView(),
    ]);
}
}