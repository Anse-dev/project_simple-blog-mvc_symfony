<?php
declare(strict_types=1);

namespace App\Tests\Unit;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserEntityTest extends KernelTestCase
{

    public function testIfReturnTrueValue()
    {
        self::bootKernel();
        //Puis recuperer le container
        $container = static::$container;
        /** @var UserRepository $userRepository */
        $userRepository = $container->get(UserRepository::class);
        $users = $userRepository->count([]);
        $this->assertEquals(20, $users);

    }
}