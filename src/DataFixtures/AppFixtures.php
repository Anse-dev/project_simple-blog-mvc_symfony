<?php


namespace App\DataFixtures;


use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture

{
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    public function __construct(CategoryRepository $categoryRepository, UserRepository $userRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $categories = $this->categoryRepository->findAll();

        $user = new User();
        $user->setRoles(["ROLE_USER"])
            ->setPassword("password")
            ->setEmail("email@gmail.com")
            ->setCreatedAt();
        $manager->persist($user);
        $category = new Category();
        $category->setTitle("santé")
            ->setCreatedAt();
        for ($a = 0; $a < 100; $a++) {
            $post = new Post();
            $post->setTitle("title-$a")
                ->setAuthor($user)
                ->setSlug("slug-$a")
                ->setBody("body-$a")
                ->setCategory($category)
                ->setCreatedAt();
            $manager->persist($post);

        }
        $manager->flush();
    }
}