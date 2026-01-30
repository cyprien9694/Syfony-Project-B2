<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;

final class CommentController extends AbstractController
{
    #[Route('/comment', name: 'app_comment')]
    public function index(CommentRepository $repo): Response
    {
        $comments = $repo->findAll();

        return $this->render('comment/index.html.twig', [
            'comments' => $comments,
            'app_user' => $this->getUser(),
        ]);
    }

    #[Route('/comment/new', name: 'comment_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $comment = new Comment();
        $comment->setAuthor($this->getUser()?->getUserIdentifier() ?? 'Invité');
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $filename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('comment_images_dir'),
                    $filename
                );
                $comment->setImage($filename);
            }

            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Commentaire ajouté !');
            return $this->redirectToRoute('app_comment');
        }

        return $this->render('comment/new.html.twig', [
            'form' => $form->createView(),
            'app_user' => $this->getUser(),
        ]);
    }


    #[Route('/comment/{id}/edit', name: 'comment_edit')]
    public function edit(Comment $comment, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Commentaire modifié !');

            return $this->redirectToRoute('app_comment');
        }

        return $this->render('comment/edit.html.twig', [
            'form' => $form->createView(),
            'app_user' => $this->getUser(),
        ]);
    }

    #[Route('/comment/{id}/delete', name: 'comment_delete', methods: ['POST'])]
    public function delete(Comment $comment, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $em->remove($comment);
            $em->flush();
            $this->addFlash('success', 'Commentaire supprimé !');
        }

        return $this->redirectToRoute('app_comment');
    }
}
