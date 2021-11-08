<?php


namespace App\Pagination;


interface PaginatorInterface
{

    public function paginate(int $page): self;

}