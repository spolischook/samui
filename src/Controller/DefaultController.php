<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Twig\Environment;

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

    /**
     * @Route(name="category_index", path="/category/{slug}", requirements={"slug" = "^((?!sitemap.xml).)*"})
     * @ParamConverter("category", class="App\Entity\Category", options={"mapping": {"slug": "slug"}})
     */
    public function category(Category $category, Environment $twig)
    {
        try {
            $template = sprintf('category/%s.html.twig', $category->getSlug());
            $twig->load($template);
        } catch (\Exception $e) {
            $template = 'category.html.twig';
        }
        return $this->render($template, [
            'category' => $category,
        ]);
    }
}
