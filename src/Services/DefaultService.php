<?php

namespace App\Services;

use Knp\Component\Pager\PaginatorInterface;

class DefaultService
{

    public function __construct (
        private PaginatorInterface $paginator
    )
    {}

    public function toPaginate($item,$request,$limit){
        return $this->paginator->paginate(
            $item,
            $request->query->getInt('page',1),
            $limit
        );
    }
}