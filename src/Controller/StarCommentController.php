<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Star;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/star/{id}/comment')]
class StarCommentController extends AbstractController
{
    #[Route('/', name: 'star_comments', methods: ['GET', 'POST'])]
    public function index(
        Star $star,
        Request $request,
        EntityManagerInterface $em,
        CommentRepository $commentRepository
    ): Response {
        // Récupérer les commentaires de cette étoile
        $comments = $commentRepository->findBy(
            ['star' => $star],
            ['createdAt' => 'DESC']
        );

        // Créer un nouveau commentaire
        $comment = new Comment();
        
        // Pré-remplir l'auteur si l'utilisateur est connecté
        if ($this->getUser()) {
            $comment->setAuthor($this->getUser()->getUserIdentifier());
            $comment->setUser($this->getUser());
        }
        
        // Associer le commentaire à l'étoile
        $comment->setStar($star);

        // Créer le formulaire
        $form = $this->createForm(CommentType::class, $comment, [
            'include_star_field' => false // Ne pas montrer le champ star car c'est déjà défini
        ]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer l'upload d'image si présent
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $safeFilename = preg_replace('/[^A-Za-z0-9\-]/', '', $imageFile->getClientOriginalName());
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('comments_images_dir'),
                    $newFilename
                );

                $comment->setImage($newFilename);
            }

            // Enregistrer le commentaire
            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Votre commentaire a été ajouté !');
            return $this->redirectToRoute('star_comments', ['id' => $star->getId()]);
        }

        return $this->render('star/comments.html.twig', [
            'star' => $star,
            'comments' => $comments,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{commentId}/edit', name: 'star_comment_edit', methods: ['GET', 'POST'])]
    public function edit(
        Star $star,
        int $commentId,
        Request $request,
        EntityManagerInterface $em,
        CommentRepository $commentRepository
    ): Response {
        $comment = $commentRepository->find($commentId);
        
        if (!$comment) {
            throw $this->createNotFoundException('Commentaire non trouvé');
        }

        // Vérifier les permissions
        $this->denyAccessUnlessGranted('EDIT', $comment);

        $form = $this->createForm(CommentType::class, $comment, [
            'include_star_field' => false
        ]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            
            $this->addFlash('success', 'Commentaire modifié !');
            return $this->redirectToRoute('star_comments', ['id' => $star->getId()]);
        }

        return $this->render('star/comment_edit.html.twig', [
            'star' => $star,
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{commentId}/delete', name: 'star_comment_delete', methods: ['POST'])]
    public function delete(
        Star $star,
        int $commentId,
        Request $request,
        EntityManagerInterface $em,
        CommentRepository $commentRepository
    ): Response {
        $comment = $commentRepository->find($commentId);
        
        if (!$comment) {
            throw $this->createNotFoundException('Commentaire non trouvé');
        }

        // Vérifier les permissions
        $this->denyAccessUnlessGranted('DELETE', $comment);

        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $em->remove($comment);
            $em->flush();
            
            $this->addFlash('success', 'Commentaire supprimé !');
        }

        return $this->redirectToRoute('star_comments', ['id' => $star->getId()]);
    }
}