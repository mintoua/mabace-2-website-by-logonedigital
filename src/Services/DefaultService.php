<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class DefaultService
{

    public function __construct (
        private PaginatorInterface $paginator,
        private CacheInterface $cache,
        private EntityManagerInterface $entityManager
    )
    {}

    public function toPaginate($item,$request,$limit){
        return $this->paginator->paginate(
            $item,
            $request->query->getInt('page',1),
            $limit
        );
    }

    public function toCache($cacheName,$period,$item){

        return $item = $this->cache->get ($cacheName, function (ItemInterface $_item) use ($item,$period){
            $_item->expiresAfter ( \DateInterval::createFromDateString ($period));
            return $item;
        });
    }
}