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
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/comment')]
class CommentController extends AbstractController
{
    #[Route('/', name: 'app_comment')]
    public function index(
        Request $request,
        CommentRepository $repo,
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ): Response {
        $comments = $repo->findBy([], ['createdAt' => 'DESC']);
        $comment = new Comment();
        $form = null;

        if ($this->getUser()) {
            $comment->setAuthor($this->getUser()->getUserIdentifier());
            $comment->setUser($this->getUser());

            $form = $this->createForm(CommentType::class, $comment);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $imageFile = $form->get('image')->getData();
                if ($imageFile) {
                    $safeFilename = $slugger->slug(
                        pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME)
                    );
                    $extension = pathinfo($imageFile->getClientOriginalName(), PATHINFO_EXTENSION);
                    if (empty($extension)) {
                        $extension = 'jpg';
                    }
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $extension;

                    $imageFile->move(
                        $this->getParameter('comments_images_dir'),
                        $newFilename
                    );

                    $comment->setImage($newFilename);
                }

                $em->persist($comment);
                $em->flush();

                return $this->redirectToRoute('app_comment');
            }
        }

        return $this->render('comment/index.html.twig', [
            'comments' => $comments,
            'form' => $form ? $form->createView() : null,
            'isAdmin' => $this->isGranted('ROLE_ADMIN')
        ]);
    }

    #[Route('/edit/{id}', name: 'comment_edit')]
    public function edit(
        Request $request,
        Comment $comment,
        EntityManagerInterface $em
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if (!$this->isGranted('ROLE_ADMIN') && $comment->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Vous ne pouvez modifier que vos propres commentaires.');
        }

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Commentaire modifié avec succès !');
            return $this->redirectToRoute('app_comment');
        }

        return $this->render('comment/edit.html.twig', [
            'form' => $form->createView(),
            'comment' => $comment
        ]);
    }

    #[Route('/delete/{id}', name: 'comment_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Comment $comment,
        EntityManagerInterface $em
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if (!$this->isGranted('ROLE_ADMIN') && $comment->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Vous ne pouvez supprimer que vos propres commentaires.');
        }

        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $em->remove($comment);
            $em->flush();
            $this->addFlash('success', 'Commentaire supprimé avec succès !');
        }

        return $this->redirectToRoute('app_comment');
    }
}
