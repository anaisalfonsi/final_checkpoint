<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Repository\ArticleCategoryRepository;
use App\Entity\ArticleCategory;
use App\Service\Slugify;

class ArticleController extends AbstractController
{
    /**
     * @Route("/blog", name="article")
     */
    public function index(ArticleRepository $articleRepository, ArticleCategoryRepository $articleCategoryRepository, Slugify $slugify)
    {
        $articles = $articleRepository->findAllRecent();

        // Categories Slug
        $categories = $articleCategoryRepository->findAll();
        foreach ($categories as $categ) {
            $category = $categ->getCategory();
            $slug = $slugify->generate($category);
        }
        
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'slug' => $slug
        ]);
    }

    /**
     * @Route("/{slug}", name="article_byCategory")
     */
    public function showByCategory($slug, ArticleRepository $articleRepository)
    {
        if ($slug === 'animals') {
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
}
