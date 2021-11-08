<?php


namespace App\Controller\Administraction;


use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ShowDashboardController
 * @package App\Controller\Administraction
 */
class ShowDashboardController
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var CommentRepository
     */
    private CommentRepository $commentRepository;
    /**
     * @var PostRepository
     */
    private PostRepository $postRepository;

    /**
     * ShowDashboardController constructor.
     * @param UserRepository $userRepository
     * @param CommentRepository $commentRepository
     * @param PostRepository $postRepository
     */
    public function __construct(
        UserRepository $userRepository,
        CommentRepository $commentRepository,
        PostRepository $postRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * @Route("/admin/dashboard", name="administration", methods={"GET"})
     * @param Environment $twig
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(Environment $twig)
    {


        dd("administration");
        return new Response(
            $twig->render("admin/home.html.twig", [
                'countPosts' => $this->postRepository->count([]),
                'countComments' => $this->commentRepository->count([]),
                'countUsers' => $this->userRepository->count([]),
            ])
        );

    }

}