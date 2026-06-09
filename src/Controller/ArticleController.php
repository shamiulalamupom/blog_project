<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;

final class ArticleController extends AbstractController
{
    #[Route('/article/{id}', name: 'app_article_show', methods: ['GET', 'POST'])]
    public function index(Article $article, Comment $comment, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = new Comment();
        $commentForm = $this->createForm(CommentType::class, $form);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $form->setArticle($article);
            $entityManager->persist($form);

            $entityManager->flush();
        }

        $comments = $article->getComments();

        return $this->render('article/show.html.twig', [
            'controller_name' => 'ArticleController',
            'article' => $article,
            'comment_form' => $commentForm->createView(),
            'comments' => $comments,
        ]);
    }
}
