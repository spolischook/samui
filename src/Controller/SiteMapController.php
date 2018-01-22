<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SiteMapController extends Controller
{
    /** @var ObjectManager  */
    private $objectManager;

    /** @var UrlGeneratorInterface  */
    private $urlGeneretor;

    public function __construct(ObjectManager $objectManager, UrlGeneratorInterface $urlGeneretor)
    {
        $this->objectManager = $objectManager;
        $this->urlGeneretor = $urlGeneretor;
    }

    /**
     * @param Request $request
     * @Route(name="sitemap", path="/sitemap.xml")
     */
    public function sitemapAction(Request $request)
    {
        $urls = [];
        $urls[] = [
            'loc' => $this->urlGeneretor->generate('index'),
            'changefreq' => 'weekly',
            'priority' => '1.0'
        ];

        $this->addCategories($urls);
        $this->addArticles($urls);

        $response = new Response();
        $response->headers->set('Content-Type', 'xml');

        $content = $this->renderView('sitemap.xml.twig', [
            'urls' => $urls,
            'hostname' => $request->getHost(),
            'scheme' => $request->getScheme(),
        ]);

        $response->setContent($content);

        return $response;
    }

    private function addArticles(array &$urls)
    {
        $articles = $this->objectManager->getRepository('App:Article')->findAll();

        /** @var Article $article */
        foreach ($articles as $article) {
            $urls[] = [
                'loc' => $this->urlGeneretor->generate('article_view', ['slug' => $article->getSlug()]),
                'changefreq' => 'weekly',
                'priority' => '1.0',
                'image' => [
                    'obj' => $article,
                    'title' => $article->getTitle(),
                ],
            ];
        }
    }

    private function addCategories(array &$urls)
    {
        $categories = $this->objectManager->getRepository('App:Category')->findAll();

        /** @var Category $category */
        foreach ($categories as $category) {
            $urls[] = [
                'loc' => $this->urlGeneretor->generate('category_index', ['slug' => $category->getSlug()]),
                'changefreq' => 'weekly',
                'priority' => '1.0',
                'image' => [
                    'obj' => $category,
                    'title' => $category->getName(),
                ],
            ];
        }
    }
}
