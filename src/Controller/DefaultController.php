<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DefaultController extends Controller
{
    /**
     * @Route(name="index", path="/")
     */
    public function index(CategoryRepository $categoryRepository)
    {
        return $this->render('index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route(name="category_index", path="/{slug}")
     * @ParamConverter("category", class="App\Entity\Category", options={"mapping": {"slug": "slug"}})
     */
    public function category(Category $category)
    {
        return $this->render('category.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route(name="article_view", path="/article/{slug}")
     * @ParamConverter("article", class="App\Entity\Article", options={"mapping": {"slug": "slug"}})
     */
    public function viewArticle(Article $article)
    {
        return $this->render('article.html.twig', [
            'article' => $article,
            'category' => $article->getCategory(),
        ]);
    }
}
