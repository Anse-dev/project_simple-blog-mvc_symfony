<?php


namespace App\Pagination;

use Doctrine\ORM\QueryBuilder as DoctrineQueryBuilder;
use Doctrine\ORM\Tools\Pagination\CountWalker;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Exception;

class Paginator implements PaginatorInterface
{
    public const PAGE_SIZE = 10;
    /**
     * @var DoctrineQueryBuilder
     */
    private DoctrineQueryBuilder $queryBuilder;
    private int $itemPerPage;
    /**
     * @var mixed
     */
    private $currentPage;
    private $results;
    private $numberOfItemsFound;

    public function __construct
    (
        DoctrineQueryBuilder $queryBuilder,
        int $itemPerPage = self::PAGE_SIZE
    )
    {
        $this->queryBuilder = $queryBuilder;
        $this->itemPerPage = $itemPerPage;
    }

    /**
     * @param int $page
     * @return $this
     * @throws Exception
     */
    public function paginate(int $page = 1): PaginatorInterface
    {
        $this->currentPage = max(1, $page);
        $firstResult = ($this->currentPage() - 1) * $this->itemPerPage;
        $query = $this->queryBuilder
            ->setFirstResult($firstResult)
            ->setMaxResults($this->itemPerPage)
            ->getQuery();
        if (0 === \count($this->queryBuilder->getDQLPart('join'))) {
            $query->setHint(CountWalker::HINT_DISTINCT, false);
        }

        $paginator = new DoctrinePaginator($query, true);

        $useOutputWalkers = \count($this->queryBuilder->getDQLPart('having') ?: []) > 0;
        $paginator->setUseOutputWalkers($useOutputWalkers);
        $this->results = $paginator->getIterator();
        $this->numberOfItemsFound = $paginator->count();

        return $this;
    }

    /**
     * @return int
     */
    public function currentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function itemPerPage(): int
    {
        return $this->itemPerPage;
    }

    /**
     * @return bool
     */
    public function hasPrevPage(): bool
    {
        return $this->currentPage > 1;
    }

    /**
     * @return int
     */
    public function getPrevPage(): int
    {
        return max(1, $this->currentPage() - 1);
    }

    /**
     * @return bool
     */
    public function hasNextPage(): bool
    {
        return $this->currentPage() < $this->getLastPage();
    }

    public function getNextPage(): int
    {
        return min($this->getLastPage(), $this->currentPage() + 1);
    }

    /**
     * @return bool
     */
    public function hasToPaginate(): bool
    {
        return $this->numberOfItemsFound() < $this->itemPerPage;
    }

    /**
     * @return int
     */
    public function numberOfItemsFound(): int
    {
        return $this->numberOfItemsFound;
    }

    /**
     * @return int
     */
    public function getLastPage(): int
    {
        return (int)ceil($this->numberOfItemsFound / $this->itemPerPage);
    }

    /**
     * @return mixed
     */
    public function getResults()
    {
        return $this->results;
    }
}