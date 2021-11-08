<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

/**
 * Class UserProfileController
 * @package App\Controller
 * @Route("/user")
 */
class UserProfileController
{
    /**
     * @var Security
     */
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="profile")
     * @param Environment $twig
     * @return Response
     */
    public function __invoke(Environment $twig): Response
    {

        $user = $this->security->getToken()->getUser();
        dd($user);
        return new Response($this->twig->render("component/_categories.html.twig", ["menus" => $menu]));
    }


}