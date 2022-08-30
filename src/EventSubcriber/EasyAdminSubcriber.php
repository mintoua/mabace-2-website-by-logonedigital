<?php

namespace App\EventSubcriber;

use App\Entity\Post;
use App\Entity\User;
use DateTimeImmutable;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Cache\CacheInterface;

class EasyAdminSubcriber implements EventSubscriberInterface
{
    private $appKernel;
    private $cache;

    public function __construct(CacheInterface $cache, KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
        $this->cache = $cache;
    }

    public static function getSubscribedEvents()
    {
        return[
            BeforeEntityPersistedEvent::class=>['persistanceProcess'],
            BeforeEntityUpdatedEvent::class=>['updatedProcess']
        ];
    }

   

    //permet de faire des actions sur l'utisateur lorsqu'il est ajouter depuis le dashboard
    public function persistanceProcess(BeforeEntityPersistedEvent $event){
        $entity = $event->getEntityInstance();
        if($entity instanceof User){
            $entity->setPassword(md5(uniqid()));
            $entity->setCreatedAt(new \DateTimeImmutable('now'));
        }
        if($entity instanceof Post){
            $entity->setCreatedAt(new \DateTimeImmutable('now'));
        }

    }

    /**
     * permet de faire des actions après la modification d'un utilisateur
     *
     * @param BeforeEntityUpdatedEvent $event
     * @return void
     */
    public function updatedProcess(BeforeEntityUpdatedEvent $event){
        $entity = $event->getEntityInstance();
        if($entity instanceof User){
            $entity->setUpdatedAt(new \DateTimeImmutable('now'));
        }
        if($entity instanceof Post){
            $entity->setUpdatedAt(new \DateTimeImmutable('now'));
        }

    }
}