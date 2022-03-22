<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Service\Admin\CategoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticleController extends AbstractController
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @Route("/admin/article", name="app_admin_article")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $articles = $em->getRepository(Article::class)->findAll();

        return $this->render('admin/article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/admin/article/create", name="app_admin_article_create")
     */
    public function createArticle(Request $request, EntityManagerInterface $em)
    {
        $categories = $this->categoryService->getAvailableCategories();

        $article = new Article();
        $articleForm = $this->createForm(ArticleType::class, $article, ['categories' => $categories]);
        $articleForm->handleRequest($request);

        if($articleForm->isSubmitted() && $articleForm->isValid()){
            $categoryId = $articleForm->get('category')->getData();
            $category = $em->getRepository(Category::class)->findOneBy(['id' => $categoryId]);

            $article->setCategory($category);

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('app_admin_article');
        }

        return $this->render('admin/article/create.html.twig', [
            'articleForm' => $articleForm->createView(),
        ]);
    }

    /**
     * @Route("/admin/article/show/{article}", name="app_admin_article_show")
     */
    public function showArticle(Article $article)
    {

        return $this->render('admin/article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/admin/article/delete/{article}", name="app_admin_article_delete")
     */
    public function deleteCategory(Article $article, EntityManagerInterface $em)
    {
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('app_admin_article');
    }
}
