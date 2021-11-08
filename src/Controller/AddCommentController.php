<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class AddCommentController
{
    /**
     * @var FormFactoryInterface
     */
    private FormFactoryInterface $formFactory;
    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $urlGenerator;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var Security
     */
    private Security $security;


    /**
     * NewCommentController constructor.
     * @param FormFactoryInterface $formFactory
     * @param UrlGeneratorInterface $urlGenerator
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager,
        Security $security
    ) {
        $this->formFactory = $formFactory;
        $this->urlGenerator = $urlGenerator;
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    /**
     * @Route("/post/{slug}/comment/new)", name="comment_new", methods={"GET","POST"} )
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function __invoke(Request $request, Post $post): Response
    {
        $comment = new Comment();
        $form = $this->formFactory
            ->create("", $comment)
            ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->security->getUser();
            $post->addComment($comment);
            $user->addComment($comment);

            $this->entityManager->persist($comment);
            $this->entityManager->flush();
        }
        return new RedirectResponse(
            $this->urlGenerator->generate("post_show", ["slug" => $post->getSlug()])
        );
    }

    public function commentFormulaire(Post $post): Response
    {
    }
}
