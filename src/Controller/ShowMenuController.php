<?php


namespace App\Controller;


use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ShowMenuController
{

    /**
     * @var Environment
     */
    private Environment $twig;
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    public function __construct(Environment $twig, CategoryRepository $categoryRepository)
    {
        $this->twig = $twig;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(): Response
    {
        $menu = $this->categoryRepository->findAll();

        return new Response($this->twig->render("component/_categories.html.twig", ["menus" => $menu]));
    }
}