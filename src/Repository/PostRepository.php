<?php

namespace App\Repository;

use App\Entity\Post;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findPosts(int $page)
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect()
            ->innerJoin("p.author", "a")
            ->leftJoin("p.tags", "t")
            ->where('p.createdAt <= :now')
            ->orderBy("p.createdAt", 'DESC')
            ->setParameter('now', new \DateTime());
        return (new Paginator($qb))->paginate($page);
    }

    public function findPostsByCategory(?int $id, int $page)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->innerJoin(
            'p.category',
            "c",
            Expr\Join::WITH,
            $qb->expr()->eq("c.id", ":id")
        )
            ->where('p.createdAt <= :now')
            ->orderBy("p.createdAt", 'DESC')
            ->setParameters(["id" => $id, 'now' => new \DateTime()]);
        return (new Paginator($qb))->paginate($page);
    }

    /**
     * @param string $string
     * @param int $limit
     * @return int|mixed|string
     */
    public function findByTag(string $string, int $limit = 2)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->innerJoin(
            "p.tags",
            "t",
            Expr\Join::WITH,
            $qb->expr()->eq("t.title", ":title")
        )
            ->where('p.createdAt <= :now')
            ->orderBy("p.createdAt", 'DESC')
            ->setParameters(["title" => $string, 'now' => new \DateTime()]);
        return $qb->setMaxResults($limit)->getQuery()->getResult();
    }
}
