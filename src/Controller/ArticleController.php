<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     */
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    /**
     * @Route("/articles/{slug}", name="article_show")
     */
    public function showArticle(Article $article, ArticleRepository $articleRepository): Response
    {   
        return $this->render('article/show.html.twig', [
       'article' => $article,
       ]);
    }
}
