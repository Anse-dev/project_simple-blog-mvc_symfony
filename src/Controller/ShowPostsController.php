<?php


namespace App\Controller;


use App\Repository\PostRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowPostsController extends AbstractController
{

    /**
     * @var TagRepository
     */
    private TagRepository $tagRepository;
    /**
     * @var PostRepository
     */
    private PostRepository $postRepository;

    public function __construct(
        TagRepository $tagRepository,
        PostRepository $postRepository
    )
    {
        $this->tagRepository = $tagRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * @Route("/", defaults={"page":"1"}, methods={"GET"}, name="blog_index")
     * @Route("/page/{page<[1-9]\d*>}", methods="GET", name="blog_index_paginated")
     * @param Request $request
     * @param int $page
     * @return Response
     */
    public function __invoke(Request $request, int $page): Response
    {

        $latestPosts = $this->postRepository->findPosts($page);
        $news = $this->postRepository->findByTag("Books");
        $selects = $this->postRepository->findByTag("tools", 3);

        return $this->render("Pages/homePage.html.twig",
            ["results" => $latestPosts, "news" => $news, "selects" => $selects]

        );
    }
}
