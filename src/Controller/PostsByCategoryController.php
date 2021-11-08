<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * Class PostsByCategoryController
 * @package App\Controller
 */
class PostsByCategoryController
{

    /**
     * @var PostRepository
     */
    private PostRepository $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @Route("/posts/category/{category}", defaults={"page":"1"}, methods={"GET"}, name="post_show_by_category")
     * @Route("/posts/category/{category}/page/{page<[1-9]\d*>}", methods={"GET"}, name="post_show_by_category_paginated")
     * @param Environment $twig
     * @param Category $category
     * @param $page
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function __invoke(Environment $twig, Category $category, $page)
    {
        $posts = $this->repository->findPostsByCategory($category->getId(), $page);
        return new Response($twig->render(
            "pages/category.html.twig",
            ["results" => $posts, "category" => $category]
        ));
    }
}
