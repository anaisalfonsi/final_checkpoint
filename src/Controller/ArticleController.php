<?php

namespace App\Controller;

use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\ArticleCategoryRepository;
use App\Repository\CommentRepository;
use App\Entity\Comment;
use App\Entity\ArticleCategory;
use App\Service\Slugify;

class ArticleController extends AbstractController
{
    /**
     * @Route("/blog", name="articles_show_all")
     */
    public function index(ArticleRepository $articleRepository, ArticleCategoryRepository $articleCategoryRepository, Slugify $slugify)
    {
        $articles = $articleRepository->findAllRecent();

        // Categories Slug
        foreach ($articles as $article) {
            $category = $article->getCategory()->getCategory();
            $slug = $slugify->generate($category);
        }
        
        return $this->render('article/show_all.html.twig', [
            'articles' => $articles,
            'slug' => $slug
        ]);
    }

    /**
     * @Route("/category/{slug}", name="articles_show_byCategory")
     */
    public function showByCategory($slug, ArticleRepository $articleRepository)
    {
        if ($slug === 'music') {
            $articles = $articleRepository->findAllByAnimals();
        }

        if ($slug === 'cosmos') {
            $articles = $articleRepository->findAllByCosmos();
        }
        
        if ($slug === 'magic') {
            $articles = $articleRepository->findAllByMagic();
        }

        foreach ($articles as $article) {
            $category = $article->getCategory()->getCategory();
        }
        
        return $this->render('article/show_by_categ.html.twig', [
            'articles' => $articles,
            'category' => $category
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show_one")
     */
    public function showArticle($id, ArticleRepository $articleRepository, Slugify $slugify, Request $request)
    {
        $article = $articleRepository->findOneBy(['id' => $id]);
        $category = $article->getCategory()->getCategory();
        $slug = $slugify->generate($category);

        $comments = $article->getComments();

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            $comment->setArticle($article);
            $comment->setAuthor($user);
            $comment->setPostedAt(new \DateTime('today'));
            $em->persist($comment);
            $em->flush();

            header("Refresh:0; url=");
        }
        
        return $this->render('article/show_one.html.twig', [
            'article' => $article,
            'comments' => $comments,
            'form' => $form->createView(),
            'category' => $category,
            'slug' => $slug
        ]);
    }

    /**
     * @Route("/{id}/watchlist", name="article_watchlist", methods={"GET","POST"})
     */
    public function addToWatchlist(Article $article, EntityManagerInterface $em) : Response
    {
        if ($this->getUser()->getArticles()->contains($article)) {
            $this->getUser()->removeArticle($article);
        }
        else {
            $this->getUser()->addArticle($article);
        }
        $em->flush();

        return $this->json([
            'isInWatchlist' => $this->getUser()->isInWatchlist($article)
        ]);
    }
}
